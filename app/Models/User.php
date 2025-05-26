<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Tournament;
use App\Models\Team;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nickname',
        'profile_picture',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define a relação para os torneios criados pelo usuário.
     */
    public function tournaments()
    {
        return $this->hasMany(Tournament::class); // Isso geralmente significa torneios que o usuário criou
    }

    /**
     * Define a relação para todas as equipes das quais o usuário é membro.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_members')->withPivot('role')->withTimestamps();
    }

    /**
     * Define a relação para as equipes que o usuário lidera.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ledTeams()
    {
        return $this->hasMany(Team::class, 'leader_id');
    }
    
    /**
     * The attributes that should be appended to the model's array form.
     *
     * @return list<string>
     */
    public function isAdmin()
    {
        // Supondo que você tenha uma coluna 'role' na tabela 'users'
        return $this->role === 'admin'; 
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}