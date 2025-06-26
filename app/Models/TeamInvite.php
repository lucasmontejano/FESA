<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamInvite extends Model
{
    protected $fillable = ['team_id', 'sender_id', 'token', 'expires_at', 'max_uses', 'uses'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isValid()
    {
        return $this->expires_at > now() && 
            ($this->max_uses === null || $this->uses < $this->max_uses) &&
            $this->team->canAddMember();
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}

