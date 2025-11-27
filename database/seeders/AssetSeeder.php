<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\BorrowingRequest;
use App\Models\MaintenanceLog;
use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data pendukung
        $categoryIds = Category::pluck('id')->toArray();
        $locationIds = Location::pluck('id')->toArray();
        $staffIds = User::where('role', 'staf')->pluck('id')->toArray();

        // Daftar Nama Aset Dummy
        $assetNames = [
            'Laptop Dell Latitude', 'MacBook Pro M1', 'Proyektor Epson', 
            'Kamera Canon EOS', 'Kursi Ergonomis', 'Meja Meeting Bundar',
            'Toyota Avanza', 'Honda Vario 150', 'Printer HP Laserjet',
            'Scanner Fujitsu', 'Monitor Samsung 24"', 'Router Mikrotik',
            'Sound System Portable', 'Papan Tulis Whiteboard', 'AC Daikin 2PK',
            'Lemari Arsip Besi', 'Tablet iPad Air', 'Drone DJI Mini',
            'Kabel HDMI 10m', 'Microphone Wireless', 'Harddisk Eksternal 2TB'
        ];

        // LOOP MEMBUAT 30 ASET
        for ($i = 1; $i <= 30; $i++) {
            
            // Pilih Status Random
            $statuses = ['Tersedia', 'Dipakai', 'Dalam Perbaikan', 'Rusak'];
            $randomStatus = $statuses[array_rand($statuses)];

            // Buat Aset
            $asset = Asset::create([
                'name' => $assetNames[array_rand($assetNames)] . ' #' . $i,
                'asset_code' => 'AST-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'location_id' => $locationIds[array_rand($locationIds)],
                'status' => $randomStatus,
                'description' => 'Aset inventaris kantor nomor urut ' . $i,
                'photo_url' => null, 
                
                // Tambahan kolom wajib
                'purchase_date' => Carbon::now()->subYears(rand(1, 5)),
                'price' => rand(1000000, 20000000), 
                'using_type' => 'individu', 
            ]);

            // --- LOGIC INTEGRITAS DATA ---

            // KASUS 1: DIPAKAI (Sedang dipinjam staff)
            if ($randomStatus === 'Dipakai') {
                $peminjam = $staffIds[array_rand($staffIds)];
                
                $asset->update(['current_user_id' => $peminjam]);

                BorrowingRequest::create([
                    'user_id' => $peminjam,
                    'asset_id' => $asset->id,
                    'start_date' => Carbon::now()->subDays(rand(1, 10)), // SEBELUMNYA: borrow_date
                    'end_date' => Carbon::now()->addDays(rand(1, 7)),   // SEBELUMNYA: return_date
                    'notes' => 'Keperluan project lapangan',            // SEBELUMNYA: reason
                    'status' => 'Disetujui', 
                ]);
            }

            // KASUS 2: DALAM PERBAIKAN atau RUSAK
            elseif ($randomStatus === 'Dalam Perbaikan' || $randomStatus === 'Rusak') {
                MaintenanceLog::create([
                    'asset_id' => $asset->id,
                    'reported_by_user_id' => $staffIds[array_rand($staffIds)],
                    'problem_description' => 'Kerusakan pada komponen utama, perlu perbaikan segera.',
                    'reported_at' => Carbon::now()->subDays(rand(1, 5)),
                    'status' => 'Dilaporkan', 
                ]);
            }

            // KASUS 3: TERSEDIA (Mungkin punya history peminjaman masa lalu)
            elseif ($randomStatus === 'Tersedia') {
                if (rand(0, 1)) {
                    BorrowingRequest::create([
                        'user_id' => $staffIds[array_rand($staffIds)],
                        'asset_id' => $asset->id,
                        'start_date' => Carbon::now()->subMonth(),          // SEBELUMNYA: borrow_date
                        'end_date' => Carbon::now()->subMonth()->addDays(3), // SEBELUMNYA: return_date
                        'notes' => 'Peminjaman masa lalu',                  // SEBELUMNYA: reason
                        'status' => 'Selesai',
                        'returned_at' => Carbon::now()->subMonth()->addDays(3), // Tambahkan tanggal pengembalian real
                    ]);
                }
            }
        }
    }
}
