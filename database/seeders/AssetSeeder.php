<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID referensi
        $catElektronik = Category::where('name', 'Elektronik (Laptop/PC)')->first()->id;
        $catKendaraan = Category::where('name', 'Kendaraan')->first()->id;
        $catPresentasi = Category::where('name', 'Peralatan Presentasi')->first()->id;
        
        $locGudang = Location::where('name', 'Gudang Utama')->first()->id;
        $locGarasi = Location::where('name', 'Garasi')->first()->id;
        $locMeeting = Location::where('name', 'Ruang Meeting A')->first()->id;

        // 1. DATA ASET individu (Contoh: Laptop untuk Staf)
        // Aset ini biasanya dipinjam jangka panjang oleh satu orang
        $laptops = [
            [
                'name' => 'MacBook Air M1',
                'asset_code' => 'LP-001',
                'category_id' => $catElektronik,
                'location_id' => $locGudang,
                'price' => 15000000,
            ],
            [
                'name' => 'Dell XPS 13',
                'asset_code' => 'LP-002',
                'category_id' => $catElektronik,
                'location_id' => $locGudang,
                'price' => 18000000,
            ],
            [
                'name' => 'Lenovo ThinkPad X1',
                'asset_code' => 'LP-003',
                'category_id' => $catElektronik,
                'location_id' => $locGudang,
                'price' => 20000000,
            ],
             [
                'name' => 'Asus Vivobook Pro',
                'asset_code' => 'LP-004',
                'category_id' => $catElektronik,
                'location_id' => $locGudang,
                'price' => 12000000,
            ],
        ];

        foreach ($laptops as $laptop) {
            Asset::create([
                'name' => $laptop['name'],
                'asset_code' => $laptop['asset_code'],
                'status' => 'Tersedia', // Enum
                'using_type' => 'individu', // Enum: individu, bersama
                'category_id' => $laptop['category_id'],
                'location_id' => $laptop['location_id'],
                'description' => 'Aset operasional standar untuk staf.',
                'purchase_date' => Carbon::now()->subMonths(rand(1, 12)),
                'price' => $laptop['price'],
                'photo_url' => null, 
            ]);
        }

        // 2. DATA ASET BERSAMA (Contoh: Mobil Kantor & Proyektor)
        // Aset ini dipinjam sebentar-sebentar dan dikembalikan ke lokasi asal
        $sharedAssets = [
            [
                'name' => 'Toyota Avanza Veloz',
                'asset_code' => 'VH-001',
                'category_id' => $catKendaraan,
                'location_id' => $locGarasi,
                'price' => 250000000,
                'description' => 'Mobil operasional plat B 1234 XYZ',
            ],
            [
                'name' => 'Epson Projector EB-X500',
                'asset_code' => 'PR-001',
                'category_id' => $catPresentasi,
                'location_id' => $locMeeting,
                'price' => 6000000,
                'description' => 'Proyektor portable untuk meeting room',
            ],
             [
                'name' => 'Kamera DSLR Canon',
                'asset_code' => 'CM-001',
                'category_id' => $catPresentasi, // Asumsi masuk sini atau buat kategori Dokumentasi
                'location_id' => $locGudang,
                'price' => 8500000,
                'description' => 'Kamera dokumentasi event kantor',
            ],
        ];

        foreach ($sharedAssets as $asset) {
            Asset::create([
                'name' => $asset['name'],
                'asset_code' => $asset['asset_code'],
                'status' => 'Tersedia',
                'using_type' => 'bersama', // Tipe BERSAMA
                'category_id' => $asset['category_id'],
                'location_id' => $asset['location_id'],
                'description' => $asset['description'],
                'purchase_date' => Carbon::now()->subYears(rand(1, 3)),
                'price' => $asset['price'],
                'photo_url' => null,
            ]);
        }
    }
}