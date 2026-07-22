<?php

namespace Database\Seeders;

use App\Models\Depot;
use App\Models\JenisBbm;
use App\Models\Spbu;
use App\Models\StokDepot;
use App\Models\StokSpbu;
use Illuminate\Database\Seeder;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $depots = Depot::all();
        $spbus = Spbu::all();
        $jenisBbms = JenisBbm::all();

        foreach ($depots as $depot) {
            foreach ($jenisBbms as $jenis) {
                $kapasitas = fake()->numberBetween(800000, 2000000);
                $minimum = $kapasitas * 0.15;
                $jumlah = fake()->numberBetween(0, 1) === 0 && fake()->boolean(20)
                    ? fake()->numberBetween((int) ($minimum * 0.3), (int) $minimum)
                    : fake()->numberBetween((int) ($kapasitas * 0.3), $kapasitas);

                StokDepot::create([
                    'depot_id' => $depot->id,
                    'jenis_bbm_id' => $jenis->id,
                    'jumlah_stok' => $jumlah,
                    'kapasitas_tangki' => $kapasitas,
                    'stok_minimum' => $minimum,
                ]);
            }
        }

        foreach ($spbus as $spbu) {
            // setiap SPBU hanya menjual sebagian jenis BBM secara acak (minimal 3 jenis)
            $jenisDipilih = $jenisBbms->random(min(4, $jenisBbms->count()));

            foreach ($jenisDipilih as $jenis) {
                $kapasitas = fake()->numberBetween(8000, 32000);
                $minimum = $kapasitas * 0.2;
                $jumlah = fake()->boolean(20)
                    ? fake()->numberBetween((int) ($minimum * 0.2), (int) $minimum)
                    : fake()->numberBetween((int) ($kapasitas * 0.25), $kapasitas);

                StokSpbu::create([
                    'spbu_id' => $spbu->id,
                    'jenis_bbm_id' => $jenis->id,
                    'jumlah_stok' => $jumlah,
                    'kapasitas_tangki' => $kapasitas,
                    'stok_minimum' => $minimum,
                ]);
            }
        }
    }
}
