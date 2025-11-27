<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Gudang Utama',
            'Ruang Server',
            'Lobby Depan',
            'Ruang Meeting Lt. 1',
            'Ruang Meeting Lt. 2',
            'Pantry',
            'Ruang Staff IT',
            'Ruang HRD',
            'Parkiran Basement',
        ];

        foreach ($locations as $loc) {
            Location::create([
                'name' => $loc,
            ]);
        }
    }
}