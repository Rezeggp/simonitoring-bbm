<?php

namespace Database\Seeders;

use App\Models\Depot;
use App\Models\Spbu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $depot = Depot::first();
        $spbu = Spbu::first();

        User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@pertamina.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operator Terminal Plumpang',
            'email' => 'operator.depot@pertamina.test',
            'password' => Hash::make('password123'),
            'role' => 'operator_depot',
            'depot_id' => $depot?->id,
        ]);

        User::create([
            'name' => 'Operator SPBU Sudirman',
            'email' => 'operator.spbu@pertamina.test',
            'password' => Hash::make('password123'),
            'role' => 'operator_spbu',
            'spbu_id' => $spbu?->id,
        ]);

        User::create([
            'name' => 'Pimpinan Regional',
            'email' => 'pimpinan@pertamina.test',
            'password' => Hash::make('password123'),
            'role' => 'pimpinan',
        ]);
    }
}
