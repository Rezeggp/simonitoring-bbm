<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_distribusi', 'depot_id', 'spbu_id', 'jenis_bbm_id', 'jumlah_liter',
        'nama_supir', 'no_polisi', 'status', 'tanggal_permintaan', 'tanggal_proses',
        'tanggal_kirim', 'tanggal_terima', 'catatan', 'created_by',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'datetime',
        'tanggal_proses' => 'datetime',
        'tanggal_kirim' => 'datetime',
        'tanggal_terima' => 'datetime',
    ];

    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }

    public function spbu()
    {
        return $this->belongsTo(Spbu::class);
    }

    public function jenisBbm()
    {
        return $this->belongsTo(JenisBbm::class);
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generateKode(): string
    {
        $tanggal = now()->format('Ymd');
        $urutan = static::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'DIST-'.$tanggal.'-'.str_pad((string) $urutan, 4, '0', STR_PAD_LEFT);
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'menunggu' => 'bg-slate-100 text-slate-600 ring-slate-200',
            'diproses' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'dikirim' => 'bg-blue-50 text-blue-700 ring-blue-200',
            'diterima' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'dibatalkan' => 'bg-red-50 text-red-700 ring-red-200',
            default => 'bg-slate-100 text-slate-600 ring-slate-200',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'dikirim' => 'Dalam Pengiriman',
            'diterima' => 'Diterima',
            'dibatalkan' => 'Dibatalkan',
            default => $this->status,
        };
    }
}
