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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel 'assets' (aset yang rusak)
            $table->foreignId('asset_id')->constrained('assets');
            
            // Foreign Key ke tabel 'users' (siapa yang melaporkan)
            $table->foreignId('reported_by_user_id')->constrained('users');

            $table->text('problem_description'); // Deskripsi masalah/kerusakan
            $table->text('action_taken')->nullable(); // Tindakan perbaikan (diisi Admin)
            $table->decimal('cost', 15, 2)->nullable(); // Biaya perbaikan (diisi Admin)
            
            // Enum untuk status perbaikan
            $table->enum('status', ['Dilaporkan', 'Dikerjakan', 'Selesai']);
            
            $table->timestamp('reported_at'); // Kapan dilaporkan
            $table->timestamp('completed_at')->nullable(); // Kapan selesai diperbaiki
            
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};