<?php

namespace Database\Seeders;

use App\Models\Spbu;
use Illuminate\Database\Seeder;

class SpbuSeeder extends Seeder
{
    public function run(): void
    {
        $spbus = [
            ['kode_spbu' => '31.123.01', 'nama_spbu' => 'SPBU Sudirman', 'alamat' => 'Jl. Jend. Sudirman No. 1', 'wilayah' => 'Jakarta Pusat', 'pemilik' => 'PT Sumber Energi'],
            ['kode_spbu' => '31.123.02', 'nama_spbu' => 'SPBU Kuningan', 'alamat' => 'Jl. HR Rasuna Said No. 10', 'wilayah' => 'Jakarta Selatan', 'pemilik' => 'PT Mitra Bahari'],
            ['kode_spbu' => '34.123.03', 'nama_spbu' => 'SPBU Cibubur', 'alamat' => 'Jl. Alternatif Cibubur No. 5', 'wilayah' => 'Jakarta Timur', 'pemilik' => 'Koperasi Karya Mandiri'],
            ['kode_spbu' => '31.123.04', 'nama_spbu' => 'SPBU Kelapa Gading', 'alamat' => 'Jl. Boulevard Raya No. 88', 'wilayah' => 'Jakarta Utara', 'pemilik' => 'PT Cahaya Nusantara'],
            ['kode_spbu' => '34.123.05', 'nama_spbu' => 'SPBU BSD', 'alamat' => 'Jl. BSD Raya Utama No. 21', 'wilayah' => 'Tangerang Selatan', 'pemilik' => 'PT Tunas Sejahtera'],
            ['kode_spbu' => '34.123.06', 'nama_spbu' => 'SPBU Bekasi Timur', 'alamat' => 'Jl. Ahmad Yani No. 45', 'wilayah' => 'Bekasi', 'pemilik' => 'PT Anugerah Energi'],
            ['kode_spbu' => '34.123.07', 'nama_spbu' => 'SPBU Depok Margonda', 'alamat' => 'Jl. Margonda Raya No. 99', 'wilayah' => 'Depok', 'pemilik' => 'PT Sinar Abadi'],
            ['kode_spbu' => '31.123.08', 'nama_spbu' => 'SPBU Pluit', 'alamat' => 'Jl. Pluit Indah Raya No. 17', 'wilayah' => 'Jakarta Utara', 'pemilik' => 'PT Bahtera Jaya'],
        ];

        foreach ($spbus as $spbu) {
            Spbu::create($spbu + ['status' => 'aktif']);
        }
    }
}
