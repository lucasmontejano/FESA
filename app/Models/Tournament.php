<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'max_participants', 
        'user_id', 
        'game', 
        'start_date', 
        'end_date',
        'tournament_date',
        'time',
        'rules',
        'prizes',
        'banner',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

