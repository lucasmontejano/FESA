<?php

namespace App\Traits;

use App\Models\Matchup;
use App\Models\Tournament;
use Illuminate\Support\Facades\Log;

trait BracketManagerTrait
{
    /**
     * Avança o vencedor de uma partida concluída para a próxima rodada no bracket.
     * Cria a próxima partida se ela não existir.
     */
    private function advanceWinner(Matchup $completedMatch): void
    {
        $tournament = $completedMatch->tournament;

        // Garante que temos os dados necessários para avançar
        if (!$tournament || !$completedMatch->winner_id) {
            Log::warning("Tentativa de avançar vencedor sem dados suficientes.", ['match_id' => $completedMatch->id]);
            return;
        }
        
        // Calcula o número total de rodadas para determinar se esta é a final
        $totalTeams = $tournament->teams()->count();
        if ($totalTeams < 2) return; // Não faz sentido ter rodadas com menos de 2 times
        $totalRounds = ceil(log($totalTeams, 2));

        // --- INÍCIO DO BLOCO DE DEBUG ---
        // Este bloco vai registrar as informações que precisamos para encontrar o problema
        Log::info("advanceWinner: Verificando status da partida.", [
            'tournament_id' => $tournament->id,
            'match_id' => $completedMatch->id,
            'match_round_number' => $completedMatch->round_number,
            'total_teams_in_tournament' => $totalTeams,
            'calculated_total_rounds' => $totalRounds,
            'is_final_round_check' => ($completedMatch->round_number >= $totalRounds), // true ou false?
        ]);
        // --- FIM DO BLOCO DE DEBUG ---
        
        if ($completedMatch->round_number >= $totalRounds) {
            // Esta foi a partida final! Finaliza o torneio.
            $tournament->status = 'completed';
            $tournament->champion_team_id = $completedMatch->winner_id;
            $tournament->save();
            Log::info("Torneio finalizado.", ['tournament_id' => $tournament->id, 'champion_id' => $tournament->champion_team_id]);
            return; // Fim do bracket
        }

        // Calcula a posição na próxima rodada
        $nextRoundNumber = $completedMatch->round_number + 1;
        $nextMatchInRound = ceil($completedMatch->match_in_round / 2);

        // Encontra ou cria a partida da próxima rodada
        $nextMatch = Matchup::firstOrCreate(
            [
                'tournament_id' => $tournament->id,
                'round_number' => $nextRoundNumber,
                'match_in_round' => $nextMatchInRound,
            ],
            ['status' => 'pending'] // Valores para criar se não existir
        );

        // Adiciona o vencedor ao slot correto (team1 ou team2) da próxima partida
        // Partidas com número ímpar (1, 3, 5...) alimentam o slot team1
        // Partidas com número par (2, 4, 6...) alimentam o slot team2
        if ($completedMatch->match_in_round % 2 !== 0) {
            $nextMatch->team1_id = $completedMatch->winner_id;
        } else {
            $nextMatch->team2_id = $completedMatch->winner_id;
        }
        
        $nextMatch->save();
        Log::info("Time {$completedMatch->winner_id} avançou para a partida {$nextMatch->id} na rodada {$nextRoundNumber}.");
    }
}