<?php

namespace Database\Seeders;

use App\Models\JenisBbm;
use Illuminate\Database\Seeder;

class JenisBbmSeeder extends Seeder
{
    public function run(): void
    {
        $jenis = [
            ['kode' => 'PRTLT', 'nama' => 'Pertalite', 'kategori' => 'gasoline', 'harga_per_liter' => 10000, 'warna_label' => '#22C55E'],
            ['kode' => 'PRTMX', 'nama' => 'Pertamax', 'kategori' => 'gasoline', 'harga_per_liter' => 12950, 'warna_label' => '#3B82F6'],
            ['kode' => 'PRTMT', 'nama' => 'Pertamax Turbo', 'kategori' => 'gasoline', 'harga_per_liter' => 14400, 'warna_label' => '#EF4444'],
            ['kode' => 'BSLR', 'nama' => 'Biosolar', 'kategori' => 'diesel', 'harga_per_liter' => 6800, 'warna_label' => '#F59E0B'],
            ['kode' => 'DXLT', 'nama' => 'Dexlite', 'kategori' => 'diesel', 'harga_per_liter' => 13400, 'warna_label' => '#8B5CF6'],
            ['kode' => 'PRTDX', 'nama' => 'Pertamina Dex', 'kategori' => 'diesel', 'harga_per_liter' => 14100, 'warna_label' => '#0EA5E9'],
        ];

        foreach ($jenis as $j) {
            JenisBbm::create($j);
        }
    }
}
