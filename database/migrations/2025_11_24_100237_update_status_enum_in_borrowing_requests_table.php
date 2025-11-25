<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- Jangan lupa import ini

return new class extends Migration
{
    public function up(): void
    {
        // Kita mendefinisikan ulang kolom status dengan menambahkan 'Selesai'
        DB::statement("ALTER TABLE borrowing_requests MODIFY COLUMN status ENUM('Pending', 'Disetujui', 'Ditolak', 'Dikembalikan', 'Selesai') NOT NULL DEFAULT 'Pending'");
    }

    public function down(): void
    {
        // Kembalikan ke kondisi semula (menghapus 'Selesai')
        // Hati-hati: Data dengan status 'Selesai' bisa error jika di-rollback
        DB::statement("ALTER TABLE borrowing_requests MODIFY COLUMN status ENUM('Pending', 'Disetujui', 'Ditolak', 'Dikembalikan') NOT NULL DEFAULT 'Pending'");
    }
};