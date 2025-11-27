<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminAndStaffUserSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class,
            AssetSeeder::class, // Jalankan TERAKHIR
        ]);
    }
}