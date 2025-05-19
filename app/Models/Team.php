<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'picture',
        'leader_id',
    ];

    /**
     * Get the leader of the team.
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * Get the members of the team.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, table: 'team_members')
                    ->withPivot(['role', 'joined_at'])
                    ->orderByPivot('role') // Default ordering
                    ->orderByPivot('joined_at');
    }

    /**
     * Get the active members of the team.
     */
    public function activeMembers()
    {
        return $this->belongsToMany(User::class, table: 'team_members')
                    ->wherePivot('role', 'active');
    }

    public function canAddMember()
    {
        return $this->members()->count() < 7;
    }

    public function canAddActiveMember()
    {
        return $this->activeMembers()->count() < 5; // Leader + 4 active = 5 total
    }

    /**
     * Get the backup members of the team.
     */
    public function backupMembers()
    {
        return $this->members()->wherePivot('role', 'backup');
    }

    // app/Models/Team.php
    public function invites()
    {
        return $this->hasMany(TeamInvite::class);
    }
}