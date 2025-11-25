<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Gudang Utama', 'description' => 'Penyimpanan aset baru atau cadangan'],
            ['name' => 'Ruang Server', 'description' => 'Lokasi perangkat jaringan'],
            ['name' => 'Lobby Kantor', 'description' => 'Area resepsionis'],
            ['name' => 'Ruang Meeting A', 'description' => 'Lantai 1'],
            ['name' => 'Garasi', 'description' => 'Area parkir kendaraan operasional'],
        ];

        foreach ($locations as $loc) {
            Location::create($loc);
        }
    }
}