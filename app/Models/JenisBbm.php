<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBbm extends Model
{
    use HasFactory;

    protected $table = 'jenis_bbms';

    protected $fillable = [
        'kode', 'nama', 'kategori', 'harga_per_liter', 'warna_label',
    ];

    public function stokDepots()
    {
        return $this->hasMany(StokDepot::class);
    }

    public function stokSpbus()
    {
        return $this->hasMany(StokSpbu::class);
    }
}
