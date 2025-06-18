<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'max_participants', 
        'user_id', 
        'game', 
        'tournament_date',
        'time',
        'rules',
        'prizes',
        'banner',
        'status',
    ];

    public function creator() 
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
        return $this->belongsToMany(Team::class, 'team_tournament', 'tournament_id', 'team_id')
                    ->withTimestamps();
    }

    public function matchups(): HasMany
    {
        return $this->hasMany(Matchup::class);
    }

    public function champion(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'champion_team_id');
    }

    public function getStartAtAttribute(): ?Carbon
    {
        if (!$this->tournament_date || !$this->time) {
            return null;
        }

        try {
            // ### INÍCIO DA CORREÇÃO ###
            // Define explicitamente que a data/hora do DB está no seu fuso horário local
            $localTimezone = 'America/Sao_Paulo';

            // Cria o objeto Carbon, informando que a string representa uma hora local
            return Carbon::parse($this->tournament_date . ' ' . $this->time, $localTimezone);
            // ### FIM DA CORREÇÃO ###
            
        } catch (\Exception $e) {
            // Se houver erro no parse, retorna nulo para evitar quebrar a aplicação
            \Illuminate\Support\Facades\Log::error("Erro ao processar data/hora para torneio ID {$this->id}: " . $e->getMessage());
            return null;
        }
    }
}