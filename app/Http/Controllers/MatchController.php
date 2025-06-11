<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matchup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\BracketManagerTrait;

class MatchController extends Controller
{   
    use AuthorizesRequests;
    use BracketManagerTrait;
    
    public function show(Matchup $match) {
        $match->load(['team1', 'team2', 'tournament']);
        return view('matches.show', compact('match'));
    }

    public function setWinner(Request $request, Matchup $match)
    {
        $request->validate([
            'winner_id' => 'required|exists:teams,id',
        ]);

        // 1. Define o vencedor e o status da partida atual
        $match->winner_id = $request->winner_id;
        $match->status = 'completed';
        $match->team1_score = ($match->team1_id == $request->winner_id) ? 1 : 0;
        $match->team2_score = ($match->team2_id == $request->winner_id) ? 1 : 0;
        $match->save();

        // Chama a função do Trait para avançar o vencedor
        $this->advanceWinner($match);

        return back()->with('success', 'Vencedor definido e avançou no bracket!');
    }

    /* private function advanceWinner(Matchup $completedMatch)
    {
        $tournament = $completedMatch->tournament;
        $winnerId = $completedMatch->winner_id;

        // Verifica se esta é a partida final
        $totalTeams = $tournament->teams()->count();
        $totalRounds = ceil(log($totalTeams, 2));
        if ($completedMatch->round_number >= $totalRounds) {
            // Esta foi a final, o torneio pode ser concluído
            $tournament->status = 'completed';
            $tournament->save();
            return;
        }

        // Encontra a partida da próxima rodada
        $nextRoundNumber = $completedMatch->round_number + 1;
        $nextMatchInRound = ceil($completedMatch->match_in_round / 2);

        $nextMatch = Matchup::firstOrCreate(
            [
                'tournament_id' => $tournament->id,
                'round_number' => $nextRoundNumber,
                'match_in_round' => $nextMatchInRound,
            ],
            ['status' => 'pending']
        );

        // Adiciona o vencedor ao slot vago da próxima partida
        if (is_null($nextMatch->team1_id)) {
            $nextMatch->team1_id = $winnerId;
        } elseif (is_null($nextMatch->team2_id)) {
            $nextMatch->team2_id = $winnerId;
        }
        $nextMatch->save();
    } */
}
