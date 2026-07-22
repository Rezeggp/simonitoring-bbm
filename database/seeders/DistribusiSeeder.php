<?php

namespace Database\Seeders;

use App\Models\Depot;
use App\Models\Distribusi;
use App\Models\JenisBbm;
use App\Models\Spbu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DistribusiSeeder extends Seeder
{
    public function run(): void
    {
        $depots = Depot::all();
        $spbus = Spbu::all();
        $jenisBbms = JenisBbm::all();
        $admin = User::where('role', 'admin')->first();

        $statusList = ['menunggu', 'diproses', 'dikirim', 'diterima', 'diterima', 'diterima', 'dibatalkan'];
        $supirList = ['Hendra Saputra', 'Joko Prasetyo', 'Rudi Hartono', 'Bambang Sutrisno', 'Yusuf Hidayat'];

        for ($i = 14; $i >= 0; $i--) {
            $jumlahHariIni = fake()->numberBetween(1, 3);

            for ($j = 0; $j < $jumlahHariIni; $j++) {
                $status = fake()->randomElement($statusList);
                $tanggalPermintaan = now()->subDays($i)->setTime(fake()->numberBetween(7, 16), fake()->numberBetween(0, 59));

                $distribusi = [
                    'kode_distribusi' => 'DIST-'.$tanggalPermintaan->format('Ymd').'-'.str_pad((string) ($j + 1), 4, '0', STR_PAD_LEFT),
                    'depot_id' => $depots->random()->id,
                    'spbu_id' => $spbus->random()->id,
                    'jenis_bbm_id' => $jenisBbms->random()->id,
                    'jumlah_liter' => fake()->numberBetween(3000, 16000),
                    'nama_supir' => fake()->randomElement($supirList),
                    'no_polisi' => 'B '.fake()->numberBetween(1000, 9999).' '.fake()->randomElement(['ABC', 'XYZ', 'PTM', 'JKT']),
                    'status' => $status,
                    'tanggal_permintaan' => $tanggalPermintaan,
                    'catatan' => fake()->boolean(30) ? 'Pengiriman sesuai jadwal rutin mingguan.' : null,
                    'created_by' => $admin?->id,
                ];

                if (in_array($status, ['diproses', 'dikirim', 'diterima'])) {
                    $distribusi['tanggal_proses'] = $tanggalPermintaan->copy()->addHours(1);
                }
                if (in_array($status, ['dikirim', 'diterima'])) {
                    $distribusi['tanggal_kirim'] = $tanggalPermintaan->copy()->addHours(3);
                }
                if ($status === 'diterima') {
                    $distribusi['tanggal_terima'] = $tanggalPermintaan->copy()->addHours(8);
                }

                Distribusi::create($distribusi);
            }
        }
    }
}
