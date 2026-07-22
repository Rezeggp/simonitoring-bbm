<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\Distribusi;
use App\Models\JenisBbm;
use App\Models\Spbu;
use App\Models\StokDepot;
use App\Models\StokSpbu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistribusiController extends Controller
{
    public function index(Request $request)
    {
        $distribusis = Distribusi::with(['depot', 'spbu', 'jenisBbm'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->depot_id, fn ($q) => $q->where('depot_id', $request->depot_id))
            ->when($request->spbu_id, fn ($q) => $q->where('spbu_id', $request->spbu_id))
            ->when($request->search, fn ($q) => $q->where('kode_distribusi', 'like', '%'.$request->search.'%'))
            ->latest('tanggal_permintaan')
            ->paginate(10)
            ->withQueryString();

        $depots = Depot::orderBy('nama_depot')->get();
        $spbus = Spbu::orderBy('nama_spbu')->get();

        return view('distribusi.index', compact('distribusis', 'depots', 'spbus'));
    }

    public function create()
    {
        $depots = Depot::where('status', 'aktif')->orderBy('nama_depot')->get();
        $spbus = Spbu::where('status', 'aktif')->orderBy('nama_spbu')->get();
        $jenisBbms = JenisBbm::orderBy('nama')->get();

        return view('distribusi.create', compact('depots', 'spbus', 'jenisBbms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'depot_id' => ['required', 'exists:depots,id'],
            'spbu_id' => ['required', 'exists:spbus,id'],
            'jenis_bbm_id' => ['required', 'exists:jenis_bbms,id'],
            'jumlah_liter' => ['required', 'numeric', 'min:1'],
            'nama_supir' => ['nullable', 'string', 'max:150'],
            'no_polisi' => ['nullable', 'string', 'max:20'],
            'tanggal_permintaan' => ['required', 'date'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ], [
            'depot_id.required' => 'Depot asal wajib dipilih.',
            'spbu_id.required' => 'SPBU tujuan wajib dipilih.',
            'jenis_bbm_id.required' => 'Jenis BBM wajib dipilih.',
            'jumlah_liter.required' => 'Jumlah liter wajib diisi.',
            'jumlah_liter.numeric' => 'Jumlah liter harus berupa angka.',
            'jumlah_liter.min' => 'Jumlah liter minimal 1 liter.',
            'tanggal_permintaan.required' => 'Tanggal permintaan wajib diisi.',
        ]);

        $stokDepot = StokDepot::where('depot_id', $data['depot_id'])
            ->where('jenis_bbm_id', $data['jenis_bbm_id'])
            ->first();

        if (! $stokDepot) {
            return back()->withErrors(['jenis_bbm_id' => 'Depot ini tidak memiliki data stok untuk jenis BBM tersebut.'])->withInput();
        }

        if ($stokDepot->jumlah_stok < $data['jumlah_liter']) {
            return back()->withErrors(['jumlah_liter' => 'Stok depot tidak cukup. Stok tersedia saat ini: '.number_format($stokDepot->jumlah_stok, 0, ',', '.').' liter.'])->withInput();
        }

        $data['kode_distribusi'] = Distribusi::generateKode();
        $data['status'] = 'menunggu';
        $data['created_by'] = $request->user()->id;

        Distribusi::create($data);

        return redirect()->route('distribusi.index')->with('success', 'Permintaan distribusi BBM berhasil dibuat dengan kode '.$data['kode_distribusi'].'.');
    }

    public function show(Distribusi $distribusi)
    {
        $distribusi->load(['depot', 'spbu', 'jenisBbm', 'dibuatOleh']);

        return view('distribusi.show', compact('distribusi'));
    }

    public function destroy(Distribusi $distribusi)
    {
        if ($distribusi->status !== 'menunggu') {
            return back()->with('error', 'Hanya distribusi dengan status "Menunggu" yang dapat dihapus.');
        }

        $distribusi->delete();

        return redirect()->route('distribusi.index')->with('success', 'Data distribusi berhasil dihapus.');
    }

    /**
     * Mengubah status alur distribusi: menunggu -> diproses -> dikirim -> diterima.
     * Saat status "dikirim", stok depot otomatis dikurangi.
     * Saat status "diterima", stok SPBU otomatis ditambahkan.
     */
    public function updateStatus(Request $request, Distribusi $distribusi)
    {
        $request->validate([
            'status' => ['required', 'in:diproses,dikirim,diterima,dibatalkan'],
        ]);

        $statusBaru = $request->status;
        $urutanValid = [
            'menunggu' => ['diproses', 'dibatalkan'],
            'diproses' => ['dikirim', 'dibatalkan'],
            'dikirim' => ['diterima'],
        ];

        if (! isset($urutanValid[$distribusi->status]) || ! in_array($statusBaru, $urutanValid[$distribusi->status], true)) {
            return back()->with('error', 'Perubahan status tidak valid untuk alur distribusi saat ini.');
        }

        DB::transaction(function () use ($distribusi, $statusBaru) {
            if ($statusBaru === 'dikirim') {
                $stokDepot = StokDepot::where('depot_id', $distribusi->depot_id)
                    ->where('jenis_bbm_id', $distribusi->jenis_bbm_id)
                    ->lockForUpdate()
                    ->first();

                if (! $stokDepot || $stokDepot->jumlah_stok < $distribusi->jumlah_liter) {
                    abort(422, 'Stok depot tidak cukup untuk mengirim distribusi ini.');
                }

                $stokDepot->decrement('jumlah_stok', $distribusi->jumlah_liter);
                $distribusi->tanggal_kirim = now();
            }

            if ($statusBaru === 'diterima') {
                $stokSpbu = StokSpbu::firstOrCreate(
                    ['spbu_id' => $distribusi->spbu_id, 'jenis_bbm_id' => $distribusi->jenis_bbm_id],
                    ['jumlah_stok' => 0, 'kapasitas_tangki' => 10000, 'stok_minimum' => 1000]
                );

                $stokSpbu->increment('jumlah_stok', $distribusi->jumlah_liter);
                $distribusi->tanggal_terima = now();
            }

            if ($statusBaru === 'diproses') {
                $distribusi->tanggal_proses = now();
            }

            $distribusi->status = $statusBaru;
            $distribusi->save();
        });

        return back()->with('success', 'Status distribusi berhasil diperbarui menjadi "'.$distribusi->statusLabel().'".');
    }
}
