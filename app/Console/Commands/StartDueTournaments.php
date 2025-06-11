<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tournament;
use App\Models\Matchup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Traits\BracketManagerTrait;

class StartDueTournaments extends Command
{

    use BracketManagerTrait;
    protected $signature = 'tournaments:start-due';
    protected $description = 'Checks for tournaments scheduled to start, closes registration, and generates initial brackets/matches.';

    public function handle()
    {

        $now = Carbon::now();
        $this->info("Verificando torneios agendados... (" . $now->toDateTimeString() . ")");

        $tournamentsToStart = Tournament::where('status', 'registration_open')
            ->whereDate('tournament_date', '<=', $now->toDateString())
            // Adicione mais lógica de tempo aqui se necessário, como discutido antes
            ->get();

        foreach ($tournamentsToStart as $tournament) {
            $this->info("Processando torneio: {$tournament->name}");
            $tournament->status = 'generating_matches';
            $tournament->save();

            $teams = $tournament->teams()->get()->shuffle(); // Embaralha para seeding aleatório

            if ($teams->count() < 2) {
                $this->warn("Torneio cancelado por falta de times.");
                $tournament->status = 'cancelled';
                $tournament->save();
                continue;
            }

            // A nova lógica de geração de partidas está aqui
            $this->generateInitialMatches($tournament, $teams);

            $tournament->status = 'live';
            $tournament->save();
            $this->info("Torneio '{$tournament->name}' está agora AO VIVO!");
        }

        $this->info('Verificação concluída.');
        return 0;
    }

    protected function generateInitialMatches(Tournament $tournament, $teams)
    {
        $teamCount = $teams->count();
        $bracketSize = pow(2, ceil(log($teamCount) / log(2)));
        $byesCount = $bracketSize - $teamCount;
        $teamsWithByes = $teams->slice(0, $byesCount);
        $teamsInRound1 = $teams->slice($byesCount)->values();
        $matchInRoundCounter = 1;
        
        // Cria partidas de BYE e avança os vencedores IMEDIATAMENTE
        foreach ($teamsWithByes as $team) {
            $byeMatch = Matchup::create([
                'tournament_id' => $tournament->id,
                'round_number' => 1,
                'match_in_round' => $matchInRoundCounter++,
                'team1_id' => $team->id,
                'team2_id' => null,
                'winner_id' => $team->id,
                'status' => 'completed',
            ]);
            $this->line("- Rodada 1 / Partida BYE para: {$team->name}");

            // CHAMA A FUNÇÃO DO TRAIT PARA AVANÇAR O VENCEDOR DO BYE
            $this->advanceWinner($byeMatch);
        }

        // Cria as partidas reais da Rodada 1
        for ($i = 0; $i < $teamsInRound1->count(); $i += 2) {
            $team1 = $teamsInRound1->get($i);
            $team2 = $teamsInRound1->get($i + 1);

            if ($team1 && $team2) {
                Matchup::create([
                    'tournament_id' => $tournament->id,
                    'round_number' => 1,
                    'match_in_round' => $matchInRoundCounter++,
                    'team1_id' => $team1->id,
                    'team2_id' => $team2->id,
                    'status' => 'pending',
                ]);
                $this->line("- Rodada 1 / Partida criada: {$team1->name} vs {$team2->name}");
            }
        }
        Log::info("Rodada 1 (com byes e avanços) gerada para o torneio ID: {$tournament->id}");
    
    }
}