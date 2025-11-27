<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAndStaffUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin Utama
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@assetflow.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Staff (Banyak)
        // Kita buat 15 staff dengan nama berbeda
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => 'Staf Karyawan ' . $i,
                'email' => 'staff' . $i . '@assetflow.test', // staff1@..., staff2@...
                'password' => Hash::make('password'),
                'role' => 'staf',
            ]);
        }
    }
}