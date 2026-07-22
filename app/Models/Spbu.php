<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spbu extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_spbu', 'nama_spbu', 'alamat', 'wilayah', 'pemilik', 'telepon', 'status',
    ];

    public function stoks()
    {
        return $this->hasMany(StokSpbu::class);
    }

    public function distribusis()
    {
        return $this->hasMany(Distribusi::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
