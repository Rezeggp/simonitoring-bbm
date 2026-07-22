<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\Distribusi;
use App\Models\JenisBbm;
use App\Models\Spbu;
use App\Models\StokDepot;
use App\Models\StokSpbu;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dariTanggal = $request->dari_tanggal ?: now()->startOfMonth()->toDateString();
        $sampaiTanggal = $request->sampai_tanggal ?: now()->toDateString();

        $distribusis = Distribusi::with(['depot', 'spbu', 'jenisBbm'])
            ->whereDate('tanggal_permintaan', '>=', $dariTanggal)
            ->whereDate('tanggal_permintaan', '<=', $sampaiTanggal)
            ->when($request->depot_id, fn ($q) => $q->where('depot_id', $request->depot_id))
            ->when($request->spbu_id, fn ($q) => $q->where('spbu_id', $request->spbu_id))
            ->when($request->jenis_bbm_id, fn ($q) => $q->where('jenis_bbm_id', $request->jenis_bbm_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('tanggal_permintaan')
            ->get();

        $totalLiterTerkirim = $distribusis->whereIn('status', ['dikirim', 'diterima'])->sum('jumlah_liter');
        $totalDistribusi = $distribusis->count();
        $totalDiterima = $distribusis->where('status', 'diterima')->count();
        $totalDibatalkan = $distribusis->where('status', 'dibatalkan')->count();

        $rekapPerJenis = $distribusis->groupBy('jenis_bbm_id')->map(function ($items) {
            return [
                'nama' => $items->first()->jenisBbm->nama,
                'total_liter' => $items->whereIn('status', ['dikirim', 'diterima'])->sum('jumlah_liter'),
                'jumlah_transaksi' => $items->count(),
            ];
        })->values();

        $depots = Depot::orderBy('nama_depot')->get();
        $spbus = Spbu::orderBy('nama_spbu')->get();
        $jenisBbms = JenisBbm::orderBy('nama')->get();

        return view('laporan.index', compact(
            'distribusis', 'dariTanggal', 'sampaiTanggal', 'totalLiterTerkirim',
            'totalDistribusi', 'totalDiterima', 'totalDibatalkan', 'rekapPerJenis',
            'depots', 'spbus', 'jenisBbms'
        ));
    }

    /**
     * Export Laporan Distribusi BBM ke CSV (Mengikuti Filter Halaman)
     */
    public function exportCsv(Request $request)
    {
        $dariTanggal = $request->dari_tanggal ?: now()->startOfMonth()->toDateString();
        $sampaiTanggal = $request->sampai_tanggal ?: now()->toDateString();

        $distribusis = Distribusi::with(['depot', 'spbu', 'jenisBbm'])
            ->whereDate('tanggal_permintaan', '>=', $dariTanggal)
            ->whereDate('tanggal_permintaan', '<=', $sampaiTanggal)
            ->when($request->depot_id, fn ($q) => $q->where('depot_id', $request->depot_id))
            ->when($request->spbu_id, fn ($q) => $q->where('spbu_id', $request->spbu_id))
            ->when($request->jenis_bbm_id, fn ($q) => $q->where('jenis_bbm_id', $request->jenis_bbm_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('tanggal_permintaan')
            ->get();

        $fileName = 'laporan_distribusi_bbm_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Tanggal Permintaan', 'Terminal BBM / Depot', 'SPBU', 'Jenis BBM', 'Jumlah (Liter)', 'Status'];

        $callback = function() use ($distribusis, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($distribusis as $index => $distribusi) {
                fputcsv($file, [
                    $index + 1,
                    $distribusi->tanggal_permintaan,
                    $distribusi->depot?->nama_depot ?? '-',
                    $distribusi->spbu?->nama_spbu ?? '-',
                    $distribusi->jenisBbm?->nama ?? '-',
                    $distribusi->jumlah_liter,
                    ucfirst($distribusi->status)
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Stok Depot / Terminal BBM ke CSV
     */
    public function exportStokDepotCsv()
    {
        $stokDepots = StokDepot::with(['depot', 'jenisBbm'])->get();
        $fileName = 'laporan_stok_depot_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Nama Terminal BBM / Depot', 'Jenis BBM', 'Stok Saat Ini (Liter)', 'Terakhir Diperbarui'];

        $callback = function() use ($stokDepots, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($stokDepots as $index => $stok) {
                fputcsv($file, [
                    $index + 1,
                    $stok->depot?->nama_depot ?? '-',
                    $stok->jenisBbm?->nama ?? '-',
                    $stok->stok ?? $stok->jumlah_liter ?? 0,
                    $stok->updated_at?->format('Y-m-d H:i:s') ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Stok SPBU ke CSV
     */
    public function exportStokSpbuCsv()
    {
        $stokSpbus = StokSpbu::with(['spbu', 'jenisBbm'])->get();
        $fileName = 'laporan_stok_spbu_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Nama SPBU', 'Jenis BBM', 'Stok Saat Ini (Liter)', 'Terakhir Diperbarui'];

        $callback = function() use ($stokSpbus, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($stokSpbus as $index => $stok) {
                fputcsv($file, [
                    $index + 1,
                    $stok->spbu?->nama_spbu ?? '-',
                    $stok->jenisBbm?->nama ?? '-',
                    $stok->stok ?? $stok->jumlah_liter ?? 0,
                    $stok->updated_at?->format('Y-m-d H:i:s') ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download Backup Database SQLite Langsung
     */
    public function backupDatabase()
    {
        $path = database_path('database.sqlite');

        if (!file_exists($path)) {
            return back()->with('error', 'File database SQLite tidak ditemukan.');
        }

        $fileName = 'backup_database_bbm_' . now()->format('Ymd_His') . '.sqlite';

        return response()->download($path, $fileName);
    }
}