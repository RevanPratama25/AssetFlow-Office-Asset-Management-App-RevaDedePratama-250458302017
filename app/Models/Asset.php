<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'asset_code',
        'description',
        'purchase_date',
        'price',
        'status',
        'using_type',
        'category_id',
        'location_id',
        'current_user_id',
        'photo_url',
    ];

    /**
     * Relasi ke tabel Category
     * Sebuah Aset 'milik' satu Kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke tabel Location
     * Sebuah Aset 'milik' satu Lokasi (bisa null)
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Relasi ke tabel User (untuk pemakai saat ini)
     * Sebuah Aset 'milik' satu User (bisa null)
     */
    public function currentUser()
    {
        return $this->belongsTo(User::class, 'current_user_id');
    }

    /**
     * Relasi ke tabel borrowingRequests & MaintenanceLogs
     * Sebuah Aset 'punya banyak' Permintaan Peminjaman dan Log Pemeliharaan
     */
    public function borrowingRequests()
    {
        return $this->hasMany(BorrowingRequest::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}