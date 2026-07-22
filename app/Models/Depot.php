<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_depot', 'nama_depot', 'lokasi', 'penanggung_jawab', 'telepon', 'status',
    ];

    public function stoks()
    {
        return $this->hasMany(StokDepot::class);
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
