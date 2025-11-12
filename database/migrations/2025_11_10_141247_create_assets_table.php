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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama aset, misal: "Laptop Dell XPS 15"
            $table->string('asset_code')->unique(); // Kode unik, misal: "LP-001"
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->date('purchase_date'); // Tanggal pembelian
            $table->decimal('price', 15, 2); // Harga beli, misal: 15000000.00
            
            // Enum sesuai ERD
            $table->enum('status', ['Tersedia', 'Dipakai', 'Rusak', 'Dalam Perbaikan']);
            $table->enum('using_type', ['individu', 'bersama']); // Tipe penggunaan
            
            // Foreign Key ke tabel 'categories'
            $table->foreignId('category_id')->constrained('categories');
            
            // Foreign Key ke tabel 'locations' (bisa null)
            $table->foreignId('location_id')->nullable()->constrained('locations');
            
            // Foreign Key ke tabel 'users' (bisa null)
            $table->foreignId('current_user_id')->nullable()->constrained('users');

            $table->string('photo_url')->nullable(); // Path/URL ke foto aset
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};