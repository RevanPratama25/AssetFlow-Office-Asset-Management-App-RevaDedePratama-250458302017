<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik (Laptop/PC)', 'description' => 'Perangkat komputer untuk staf'],
            ['name' => 'Kendaraan', 'description' => 'Kendaraan operasional kantor'],
            ['name' => 'Peralatan Presentasi', 'description' => 'Proyektor, Layar, dll'],
            ['name' => 'Furniture', 'description' => 'Meja, Kursi, Lemari'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}