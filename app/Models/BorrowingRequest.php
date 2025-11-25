<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'start_date',
        'end_date',
        'status', // Enum
        'notes',
    ];

    // Relasi ke User (Peminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Aset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}