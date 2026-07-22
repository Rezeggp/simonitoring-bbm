<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\JenisBbm;
use App\Models\StokDepot;
use Illuminate\Http\Request;

class StokDepotController extends Controller
{
    public function index(Request $request)
    {
        $depots = Depot::orderBy('nama_depot')->get();
        $depotId = $request->depot_id ?: $depots->first()?->id;

        $stoks = StokDepot::with(['depot', 'jenisBbm'])
            ->when($depotId, fn ($q) => $q->where('depot_id', $depotId))
            ->get();

        return view('stok-depot.index', compact('depots', 'stoks', 'depotId'));
    }

    public function create()
    {
        $depots = Depot::orderBy('nama_depot')->get();
        $jenisBbms = JenisBbm::orderBy('nama')->get();

        return view('stok-depot.create', compact('depots', 'jenisBbms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'depot_id' => ['required', 'exists:depots,id'],
            'jenis_bbm_id' => ['required', 'exists:jenis_bbms,id'],
            'jumlah_stok' => ['required', 'numeric', 'min:0'],
            'kapasitas_tangki' => ['required', 'numeric', 'min:1'],
            'stok_minimum' => ['required', 'numeric', 'min:0'],
        ], [
            'depot_id.required' => 'Depot wajib dipilih.',
            'jenis_bbm_id.required' => 'Jenis BBM wajib dipilih.',
            'jumlah_stok.required' => 'Jumlah stok wajib diisi.',
            'kapasitas_tangki.required' => 'Kapasitas tangki wajib diisi.',
        ]);

        if ($data['jumlah_stok'] > $data['kapasitas_tangki']) {
            return back()->withErrors(['jumlah_stok' => 'Jumlah stok tidak boleh melebihi kapasitas tangki.'])->withInput();
        }

        $exists = StokDepot::where('depot_id', $data['depot_id'])->where('jenis_bbm_id', $data['jenis_bbm_id'])->exists();
        if ($exists) {
            return back()->withErrors(['jenis_bbm_id' => 'Data stok untuk depot dan jenis BBM ini sudah ada. Silakan edit data yang sudah ada.'])->withInput();
        }

        StokDepot::create($data);

        return redirect()->route('stok-depot.index', ['depot_id' => $data['depot_id']])->with('success', 'Data tangki stok berhasil ditambahkan.');
    }

    public function edit(StokDepot $stokDepot)
    {
        return view('stok-depot.edit', compact('stokDepot'));
    }

    public function update(Request $request, StokDepot $stokDepot)
    {
        $data = $request->validate([
            'jumlah_stok' => ['required', 'numeric', 'min:0'],
            'kapasitas_tangki' => ['required', 'numeric', 'min:1'],
            'stok_minimum' => ['required', 'numeric', 'min:0'],
        ], [
            'jumlah_stok.required' => 'Jumlah stok wajib diisi.',
            'jumlah_stok.numeric' => 'Jumlah stok harus berupa angka.',
            'kapasitas_tangki.required' => 'Kapasitas tangki wajib diisi.',
        ]);

        if ($data['jumlah_stok'] > $data['kapasitas_tangki']) {
            return back()->withErrors(['jumlah_stok' => 'Jumlah stok tidak boleh melebihi kapasitas tangki.'])->withInput();
        }

        $stokDepot->update($data);

        return redirect()->route('stok-depot.index', ['depot_id' => $stokDepot->depot_id])->with('success', 'Stok depot berhasil diperbarui.');
    }

    public function destroy(StokDepot $stokDepot)
    {
        $depotId = $stokDepot->depot_id;
        $stokDepot->delete();

        return redirect()->route('stok-depot.index', ['depot_id' => $depotId])->with('success', 'Data stok berhasil dihapus.');
    }
}
