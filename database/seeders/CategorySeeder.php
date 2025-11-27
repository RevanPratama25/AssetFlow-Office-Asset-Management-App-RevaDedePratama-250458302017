<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik & Gadget',
            'Furniture Kantor',
            'Kendaraan Dinas',
            'Alat Tulis & Dokumen',
            'Peralatan Kebersihan',
            'Perangkat Jaringan (Network)',
            'Audio Visual',
            'Aksesoris Komputer',
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'description' => 'Kategori untuk ' . $cat,
            ]);
        }
    }
}