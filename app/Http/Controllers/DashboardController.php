<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\Distribusi;
use App\Models\JenisBbm;
use App\Models\Spbu;
use App\Models\StokDepot;
use App\Models\StokSpbu;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDepot = Depot::where('status', 'aktif')->count();
        $totalSpbu = Spbu::where('status', 'aktif')->count();
        $totalJenisBbm = JenisBbm::count();

        $distribusiHariIni = Distribusi::whereDate('tanggal_permintaan', now()->toDateString())->count();
        $distribusiDalamProses = Distribusi::whereIn('status', ['menunggu', 'diproses', 'dikirim'])->count();

        $totalStokDepot = StokDepot::sum('jumlah_stok');
        $totalStokSpbu = StokSpbu::sum('jumlah_stok');

        $stokMenipisDepot = StokDepot::with(['depot', 'jenisBbm'])
            ->whereColumn('jumlah_stok', '<=', 'stok_minimum')
            ->orderBy('jumlah_stok')
            ->take(8)
            ->get();

        $stokMenipisSpbu = StokSpbu::with(['spbu', 'jenisBbm'])
            ->whereColumn('jumlah_stok', '<=', 'stok_minimum')
            ->orderBy('jumlah_stok')
            ->take(8)
            ->get();

        $stokPerJenis = JenisBbm::all()->map(function ($jenis) {
            return [
                'nama' => $jenis->nama,
                'warna' => $jenis->warna_label,
                'depot' => (float) StokDepot::where('jenis_bbm_id', $jenis->id)->sum('jumlah_stok'),
                'spbu' => (float) StokSpbu::where('jenis_bbm_id', $jenis->id)->sum('jumlah_stok'),
            ];
        });

        $distribusi7Hari = collect(range(6, 0))->map(function ($i) {
            $tanggal = now()->subDays($i)->toDateString();

            return [
                'tanggal' => now()->subDays($i)->translatedFormat('d M'),
                'jumlah' => Distribusi::whereDate('tanggal_permintaan', $tanggal)->count(),
                'liter' => (float) Distribusi::whereDate('tanggal_permintaan', $tanggal)
                    ->whereIn('status', ['dikirim', 'diterima'])
                    ->sum('jumlah_liter'),
            ];
        });

        $distribusiTerbaru = Distribusi::with(['depot', 'spbu', 'jenisBbm'])
            ->latest('tanggal_permintaan')
            ->take(6)
            ->get();

        $distribusiPerStatus = Distribusi::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('dashboard.index', [
            'totalDepot' => $totalDepot,
            'totalSpbu' => $totalSpbu,
            'totalJenisBbm' => $totalJenisBbm,
            'distribusiHariIni' => $distribusiHariIni,
            'distribusiDalamProses' => $distribusiDalamProses,
            'totalStokDepot' => $totalStokDepot,
            'totalStokSpbu' => $totalStokSpbu,
            'stokMenipisDepot' => $stokMenipisDepot,
            'stokMenipisSpbu' => $stokMenipisSpbu,
            'stokPerJenis' => $stokPerJenis,
            'distribusi7Hari' => $distribusi7Hari,
            'distribusiTerbaru' => $distribusiTerbaru,
            'distribusiPerStatus' => $distribusiPerStatus,
        ]);
    }
}
