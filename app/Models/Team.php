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
        return $this->belongsToMany(User::class, 'team_members')->withPivot('role');
    }

    /**
     * Get the active members of the team.
     */
    public function activeMembers()
    {
        return $this->members()->wherePivot('role', 'active');
    }

    /**
     * Get the backup members of the team.
     */
    public function backupMembers()
    {
        return $this->members()->wherePivot('role', 'backup');
    }
}