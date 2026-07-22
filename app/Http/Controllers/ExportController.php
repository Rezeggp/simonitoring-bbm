<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\StokDepot;
use App\Models\StokSpbu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    /**
     * Export data distribusi ke CSV berdasarkan filter laporan.
     * → Data Recovery Testing & Data Backup Testing
     */
    public function distribusiCsv(Request $request)
    {
        $dariTanggal    = $request->dari_tanggal ?: now()->startOfMonth()->toDateString();
        $sampaiTanggal  = $request->sampai_tanggal ?: now()->toDateString();

        $distribusis = Distribusi::with(['depot', 'spbu', 'jenisBbm', 'dibuatOleh'])
            ->whereDate('tanggal_permintaan', '>=', $dariTanggal)
            ->whereDate('tanggal_permintaan', '<=', $sampaiTanggal)
            ->when($request->depot_id,     fn ($q) => $q->where('depot_id',     $request->depot_id))
            ->when($request->spbu_id,      fn ($q) => $q->where('spbu_id',      $request->spbu_id))
            ->when($request->jenis_bbm_id, fn ($q) => $q->where('jenis_bbm_id', $request->jenis_bbm_id))
            ->when($request->status,       fn ($q) => $q->where('status',       $request->status))
            ->orderByDesc('tanggal_permintaan')
            ->get();

        $filename = 'distribusi-bbm-' . $dariTanggal . '-sd-' . $sampaiTanggal . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-store, no-cache',
        ];

        $callback = function () use ($distribusis) {
            $handle = fopen('php://output', 'w');
            // BOM untuk Excel agar UTF-8 terbaca dengan benar
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom
            fputcsv($handle, [
                'Kode Distribusi', 'Tanggal Permintaan', 'Terminal Asal', 'SPBU Tujuan',
                'Jenis BBM', 'Jumlah (Liter)', 'Nama Supir', 'No. Polisi',
                'Status', 'Tanggal Diproses', 'Tanggal Dikirim', 'Tanggal Diterima',
                'Dibuat Oleh', 'Catatan',
            ], ';');

            foreach ($distribusis as $d) {
                fputcsv($handle, [
                    $d->kode_distribusi,
                    $d->tanggal_permintaan?->format('d/m/Y H:i'),
                    $d->depot->nama_depot ?? '-',
                    $d->spbu->nama_spbu ?? '-',
                    $d->jenisBbm->nama ?? '-',
                    number_format($d->jumlah_liter, 2, ',', '.'),
                    $d->nama_supir ?? '-',
                    $d->no_polisi ?? '-',
                    $d->statusLabel(),
                    $d->tanggal_proses?->format('d/m/Y H:i') ?? '-',
                    $d->tanggal_kirim?->format('d/m/Y H:i') ?? '-',
                    $d->tanggal_terima?->format('d/m/Y H:i') ?? '-',
                    $d->dibuatOleh->name ?? '-',
                    $d->catatan ?? '-',
                ], ';');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data stok semua terminal ke CSV.
     */
    public function stokDepotCsv()
    {
        $stoks = StokDepot::with(['depot', 'jenisBbm'])->orderBy('depot_id')->get();

        $filename = 'stok-terminal-bbm-' . now()->format('Y-m-d') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($stoks) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['Terminal', 'Jenis BBM', 'Jumlah Stok (L)', 'Kapasitas Tangki (L)', 'Stok Minimum (L)', 'Persentase (%)'], ';');
            foreach ($stoks as $s) {
                fputcsv($handle, [
                    $s->depot->nama_depot ?? '-',
                    $s->jenisBbm->nama ?? '-',
                    number_format($s->jumlah_stok, 2, ',', '.'),
                    number_format($s->kapasitas_tangki, 2, ',', '.'),
                    number_format($s->stok_minimum, 2, ',', '.'),
                    number_format($s->persentase, 1, ',', '.'),
                ], ';');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data stok semua SPBU ke CSV.
     */
    public function stokSpbuCsv()
    {
        $stoks = StokSpbu::with(['spbu', 'jenisBbm'])->orderBy('spbu_id')->get();

        $filename = 'stok-spbu-' . now()->format('Y-m-d') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($stoks) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['SPBU', 'Jenis BBM', 'Jumlah Stok (L)', 'Kapasitas Tangki (L)', 'Stok Minimum (L)', 'Persentase (%)'], ';');
            foreach ($stoks as $s) {
                fputcsv($handle, [
                    $s->spbu->nama_spbu ?? '-',
                    $s->jenisBbm->nama ?? '-',
                    number_format($s->jumlah_stok, 2, ',', '.'),
                    number_format($s->kapasitas_tangki, 2, ',', '.'),
                    number_format($s->stok_minimum, 2, ',', '.'),
                    number_format($s->persentase, 1, ',', '.'),
                ], ';');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Backup: download file database SQLite langsung.
     * → Data Backup and Restore Testing
     */
    public function backupDatabase()
    {
        $dbPath = database_path('database.sqlite');

        if (! file_exists($dbPath)) {
            return back()->with('error', 'File database tidak ditemukan. Pastikan menggunakan koneksi SQLite.');
        }

        $filename = 'backup-simonitoring-bbm-' . now()->format('Y-m-d-His') . '.sqlite';

        return response()->download($dbPath, $filename, [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-store, no-cache',
        ]);
    }
}
