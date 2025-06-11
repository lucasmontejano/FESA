<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'max_participants', 
        'user_id', 
        'game', 
        'start_date', //Registration start date
        'end_date', //Registration end date
        'tournament_date', // Date of the tournament
        'time', // Time of the tournament
        'rules',
        'prizes',
        'banner',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function creator() // Renomeei de 'user' para 'creator' para evitar confusão com o usuário autenticado
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * As equipes que estão inscritas neste torneio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        // O nome da tabela pivot é 'team_tournament'
        // As chaves estrangeiras são 'tournament_id' e 'team_id' por padrão,
        // mas é bom ser explícito se os nomes forem diferentes.
        return $this->belongsToMany(Team::class, 'team_tournament', 'tournament_id', 'team_id')
                    ->withTimestamps(); // Se você adicionou timestamps à sua tabela pivot
    }

    public function matchups(): HasMany
    {
        return $this->hasMany(Matchup::class); // Assuming Matchup model exists
    }

    public function champion(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'champion_team_id');
    }
}