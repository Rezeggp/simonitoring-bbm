<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepotSeeder::class,
            SpbuSeeder::class,
            JenisBbmSeeder::class,
            UserSeeder::class,
            StokSeeder::class,
            DistribusiSeeder::class,
        ]);
    }
}
