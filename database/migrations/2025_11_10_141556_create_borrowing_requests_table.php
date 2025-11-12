<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowing_requests', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel 'users' (siapa yang mengajukan)
            $table->foreignId('user_id')->constrained('users');
            
            // Foreign Key ke tabel 'assets' (aset yang diminta)
            $table->foreignId('asset_id')->constrained('assets');

            $table->date('start_date'); // Tanggal mulai pemakaian
            $table->date('end_date'); // Perkiraan tanggal kembali
            
            // Enum untuk status pengajuan
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak', 'Dikembalikan']);
            
            $table->text('notes')->nullable(); // Catatan/alasan pemakaian

            // Foreign Key ke tabel 'users' (siapa admin yang menyetujui)
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users');
            
            $table->timestamp('approved_at')->nullable(); // Kapan disetujui
            $table->timestamp('returned_at')->nullable(); // Kapan dikembalikan
            
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_requests');
    }
};