<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokSpbu extends Model
{
    use HasFactory;

    protected $fillable = [
        'spbu_id', 'jenis_bbm_id', 'jumlah_stok', 'kapasitas_tangki', 'stok_minimum',
    ];

    public function spbu()
    {
        return $this->belongsTo(Spbu::class);
    }

    public function jenisBbm()
    {
        return $this->belongsTo(JenisBbm::class);
    }

    public function getPersentaseAttribute(): float
    {
        if ((float) $this->kapasitas_tangki <= 0) {
            return 0;
        }

        return round(($this->jumlah_stok / $this->kapasitas_tangki) * 100, 1);
    }

    public function isMenipis(): bool
    {
        return (float) $this->jumlah_stok <= (float) $this->stok_minimum;
    }
}
