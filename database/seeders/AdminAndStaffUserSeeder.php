<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminAndStaffUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Seeder Akun Admin
        User::create([
            'name' => 'Admin AssetFlow',
            'email' => 'admin@assetflow.com',
            'password' => Hash::make('password'), // password dapat diganti sesuai kebutuhan
            'role' => 'admin',
        ]);

        // 2. Buat Akun Staf (Contoh 1)
        User::create([
            'name' => 'Staf AssetFlow',
            'email' => 'staf@assetflow.com',
            'password' => Hash::make('password'), // password dapat diganti sesuai kebutuhan
            'role' => 'staf',
        ]);

        // 3. Buat Akun Staf (Contoh 2)
        User::create([
            'name' => 'Udin Staf',
            'email' => 'udin@assetflow.com',
            'password' => Hash::make('password'),   // password dapat diganti sesuai kebutuhan
            'role' => 'staf',
        ]);
    }
}
