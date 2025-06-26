<?php

namespace App\Services;

use App\Models\Tournament;
use App\Models\Matchup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Traits\BracketManagerTrait;

class TournamentService
{
    use BracketManagerTrait; // Reutiliza a lógica para avançar os vencedores

    /**
     * Inicia um torneio, gerando o bracket inicial.
     * Retorna true em caso de sucesso, false em caso de falha.
     *
     * @param Tournament $tournament
     * @return bool
     */
    public function startTournament(Tournament $tournament): bool
    {
        // Pega os times inscritos e embaralha para seeding aleatório
        $teams = $tournament->teams()->get()->shuffle();

        // Validação: Precisa de pelo menos 2 times
        if ($teams->count() < 2) {
            Log::warning("Torneio ID {$tournament->id} cancelado por falta de times.");
            $tournament->status = 'cancelled';
            $tournament->save();
            return false;
        }

        // Atualiza o status e gera as partidas
        $tournament->status = 'generating_matches';
        $tournament->save();

        $this->generateBracketMatches($tournament, $teams);

        $tournament->status = 'live';
        $tournament->save();
        
        Log::info("Torneio '{$tournament->name}' (ID: {$tournament->id}) foi iniciado e está AO VIVO!");
        return true;
    }

    /**
     * Gera o bracket completo para um torneio, lidando com "byes".
     * Esta é a mesma função que estava no seu comando.
     */
    protected function generateBracketMatches(Tournament $tournament, Collection $teams): void
    {
        $teamCount = $teams->count();
        $bracketSize = pow(2, ceil(log($teamCount) / log(2)));
        $byesCount = $bracketSize - $teamCount;

        $teamsWithByes = $teams->slice(0, $byesCount);
        $teamsInRound1 = $teams->slice($byesCount)->values();

        $matchInRoundCounter = 1;

        // Cria partidas de BYE e avança os vencedores imediatamente
        foreach ($teamsWithByes as $team) {
            $byeMatch = Matchup::create([
                'tournament_id' => $tournament->id, 'round_number' => 1,
                'match_in_round' => $matchInRoundCounter++, 'team1_id' => $team->id,
                'team2_id' => null, 'winner_id' => $team->id, 'status' => 'completed',
            ]);
            $this->advanceWinner($byeMatch); // Avança o time com BYE
        }

        // Cria as partidas reais da Rodada 1
        for ($i = 0; $i < $teamsInRound1->count(); $i += 2) {
            if (isset($teamsInRound1[$i]) && isset($teamsInRound1[$i + 1])) {
                Matchup::create([
                    'tournament_id' => $tournament->id, 'round_number' => 1,
                    'match_in_round' => $matchInRoundCounter++,
                    'team1_id' => $teamsInRound1[$i]->id, 'team2_id' => $teamsInRound1[$i + 1]->id,
                    'status' => 'pending',
                ]);
            }
        }
    }
}