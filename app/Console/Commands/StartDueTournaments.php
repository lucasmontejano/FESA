<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tournament;
use App\Models\Matchup; // You'll create this
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StartDueTournaments extends Command
{
    protected $signature = 'tournaments:start-due';
    protected $description = 'Checks for tournaments scheduled to start, closes registration, and generates initial brackets/matches.';

    public function handle()
    {
        $now = Carbon::now();
        $this->info("Scheduler running at: " . $now->toDateTimeString());

        // Find tournaments that are scheduled to start and are still in 'registration_open'
        // Since tournament_date is not cast to datetime in the model, we treat it as a string.
        // Time is also a string. We'll fetch broadly and then filter precisely.
        $potentialTournamentsToStart = Tournament::where('status', 'registration_open') // Or your pre-start status
            ->whereDate('tournament_date', '<=', $now->toDateString()) // Tournament date is today or in the past
            ->get();

        if ($potentialTournamentsToStart->isEmpty()) {
            $this->info('No potential tournaments based on date and status.');
            return 0;
        }

        $tournamentsToStart = $potentialTournamentsToStart->filter(function ($tournament) use ($now) {
            if (!$tournament->tournament_date || !$tournament->time) {
                Log::warning("Tournament ID {$tournament->id} has missing tournament_date or time.");
                return false;
            }
            try {
                $timeString = $tournament->time;
                $format = (strlen($timeString) === 8) ? 'Y-m-d H:i:s' : 'Y-m-d H:i'; // Basic check for seconds
                $tournamentStartDateTime = Carbon::createFromFormat($format, $tournament->tournament_date . ' ' . $timeString, config('app.timezone'));
                return $tournamentStartDateTime->lte($now); 
            } catch (\Exception $e) {
                Log::error("Error parsing date/time for tournament ID {$tournament->id}: Date='{$tournament->tournament_date}', Time='{$tournament->time}'. Error: " . $e->getMessage());
                return false;
            }
        });

        if ($tournamentsToStart->isEmpty()) {
            $this->info('No tournaments due to start at this precise time after filtering.');
            return 0;
        }

        foreach ($tournamentsToStart as $tournament) {
            $this->info("Processing tournament: {$tournament->name} (ID: {$tournament->id})");
            Log::info("Attempting to start tournament: {$tournament->name} (ID: {$tournament->id})");

            // 1. Update tournament status
            $tournament->status = 'generating_matches'; // Or 'registration_closed'
            $tournament->save();
            $this->info("Tournament status set to 'generating_matches'.");

            // 2. Fetch subscribed teams
            $subscribedTeams = $tournament->teams()->get()->shuffle();

            if ($subscribedTeams->count() < 2) { // Or your minimum required teams
                $this->warn("Tournament {$tournament->name} has less than 2 teams. Cannot generate matches. Setting to cancelled.");
                Log::warning("Tournament {$tournament->name} (ID: {$tournament->id}) has less than 2 teams. Matches not generated.");
                $tournament->status = 'cancelled';
                $tournament->save();
                continue;
            }

            // 3. Generate Bracket/Matches
            $this->generateInitialMatches($tournament, $subscribedTeams);

            // 4. Update tournament status to 'live'
            $tournament->status = 'live';
            $tournament->save();
            $this->info("Tournament {$tournament->name} is now live.");
            Log::info("Tournament {$tournament->name} (ID: {$tournament->id}) is now live.");
        }
        $this->info('Finished processing due tournaments.');
        return 0;
    }

    protected function generateInitialMatches(Tournament $tournament, $teams)
    {
        $this->info("Generating matches for {$teams->count()} teams in tournament {$tournament->name}.");
        $teamsQueue = $teams->values();
        $roundNumber = 1;
        $matchInRound = 1;

        for ($i = 0; $i < $teamsQueue->count(); $i += 2) {
            $team1 = $teamsQueue->get($i);
            $team2 = $teamsQueue->get($i + 1);

            if ($team1 && $team2) {
                Matchup::create([
                    'tournament_id' => $tournament->id,
                    'round_number' => $roundNumber,
                    'match_in_round' => $matchInRound++,
                    'team1_id' => $team1->id,
                    'team2_id' => $team2->id,
                    'status' => 'pending',
                ]);
                $this->line("- Match created: {$team1->name} vs {$team2->name}");
            } elseif ($team1) {
                Matchup::create([
                    'tournament_id' => $tournament->id,
                    'round_number' => $roundNumber,
                    'match_in_round' => $matchInRound++,
                    'team1_id' => $team1->id,
                    'team2_id' => null,
                    'winner_id' => $team1->id,
                    'status' => 'completed', // Bye match is completed by default
                ]);
                $this->line("- Match created: {$team1->name} gets a BYE");
            }
        }
        Log::info("Generated initial matches for tournament ID: {$tournament->id}");
    }
}