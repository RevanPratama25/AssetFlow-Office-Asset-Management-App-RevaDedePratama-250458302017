<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'reported_by_user_id',
        'problem_description',
        'action_taken',
        'cost',
        'status',
        'reported_at', 
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }
}