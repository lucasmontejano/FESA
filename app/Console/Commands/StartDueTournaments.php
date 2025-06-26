<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tournament;
use App\Models\Matchup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Traits\BracketManagerTrait;
use App\Services\TournamentService;

class StartDueTournaments extends Command
{
    protected $signature = 'tournaments:start-due';
    protected $description = 'Checks for tournaments scheduled to start, closes registration, and generates initial brackets/matches.';

    public function handle(TournamentService $tournamentService)
    {
        $timezone = config('app.timezone', 'America/Sao_Paulo');
        $now = \Carbon\Carbon::now('America/Sao_Paulo');
        Log::channel('daily')->info("--- [Scheduler] Iniciando verificação de torneios. Hora atual: {$now->toDateTimeString()} ({$timezone}) ---");

        // Pega todos os torneios com registro aberto para verificar a data no PHP (mais seguro)
        $potentialTournaments = Tournament::where('status', 'registration_open')->get();
        Log::channel('daily')->info("[Scheduler] Encontrados {$potentialTournaments->count()} torneios com status 'registration_open'.");

        if ($potentialTournaments->isEmpty()) {
            $this->info('Nenhum torneio com registro aberto para verificar.');
            return 0;
        }

        $tournamentsToStart = $potentialTournaments->filter(function ($tournament) use ($now) {
            // --- LOGS DETALHADOS DENTRO DO FILTRO ---
            Log::channel('daily')->info("--- [Verificando] Torneio ID: {$tournament->id} ('{$tournament->name}') ---");
            
            // 1. Log dos dados brutos que vêm do banco de dados
            Log::channel('daily')->info("  [Dados Brutos do DB]", [
                'tournament_date' => $tournament->getRawOriginal('tournament_date'),
                'time' => $tournament->getRawOriginal('time')
            ]);
            
            // 2. Log do objeto de data/hora que o modelo está criando através do accessor 'start_at'
            $startAt = $tournament->start_at; // Usa o accessor que criamos no modelo Tournament
            Log::channel('daily')->info("  [Objeto Carbon Gerado]", [
                'start_at_iso' => $startAt ? $startAt->toIso8601String() : 'NULO',
                'start_at_timezone' => $startAt ? $startAt->tzName : 'N/A'
            ]);

            if (!$startAt) {
                Log::channel('daily')->warning("  [Resultado] Torneio ID: {$tournament->id} ignorado por não ter uma data/hora de início válida.");
                return false;
            }

            // 3. Log da comparação final
            $isDue = $startAt->isPast(); // isPast() compara com a hora atual
            Log::channel('daily')->info("  [Comparação]", [
                'horario_do_torneio' => $startAt->toDateTimeString(),
                'horario_atual' => $now->toDateTimeString(),
                'deve_comecar_agora' => $isDue, // Este é o resultado do filtro
            ]);
            Log::channel('daily')->info("--- [Fim da Verificação] Torneio ID: {$tournament->id} ---");

            return $isDue;
        });

        if ($tournamentsToStart->isEmpty()) {
            $this->info('Nenhum torneio para iniciar neste exato momento.');
            return 0;
        }
        
        $this->info("PROCESSANDO {$tournamentsToStart->count()} TORNEIO(S) AGORA...");

        foreach ($tournamentsToStart as $tournament) {
            $this->info("Iniciando torneio: {$tournament->name}");
            $tournamentService->startTournament($tournament); // Usa o serviço
        }

        $this->info('Verificação concluída.');
        return 0;
    }
}