<?php

namespace Database\Seeders;

use App\Models\Depot;
use Illuminate\Database\Seeder;

class DepotSeeder extends Seeder
{
    public function run(): void
    {
        $depots = [
            ['kode_depot' => 'TBBM-PLP', 'nama_depot' => 'Terminal BBM Plumpang', 'lokasi' => 'Jakarta Utara, DKI Jakarta', 'penanggung_jawab' => 'Budi Santoso', 'telepon' => '021-4301050'],
            ['kode_depot' => 'TBBM-BLG', 'nama_depot' => 'Terminal BBM Balongan', 'lokasi' => 'Indramayu, Jawa Barat', 'penanggung_jawab' => 'Siti Rahayu', 'telepon' => '0234-428000'],
            ['kode_depot' => 'TBBM-CLP', 'nama_depot' => 'Terminal BBM Cilacap', 'lokasi' => 'Cilacap, Jawa Tengah', 'penanggung_jawab' => 'Agus Wijaya', 'telepon' => '0282-695100'],
            ['kode_depot' => 'TBBM-TBN', 'nama_depot' => 'Terminal BBM Tanjung Priok', 'lokasi' => 'Jakarta Utara, DKI Jakarta', 'penanggung_jawab' => 'Dewi Lestari', 'telepon' => '021-4301777'],
        ];

        foreach ($depots as $depot) {
            Depot::create($depot + ['status' => 'aktif']);
        }
    }
}
