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
}