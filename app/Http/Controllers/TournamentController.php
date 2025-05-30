<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = Tournament::latest()->get();
        return view('dashboard', ['tournaments' => $tournaments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentYear = now()->year;
        $nextYear = $currentYear + 1;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'game' => 'required|string',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) use ($currentYear, $nextYear) {
                    $year = date('Y', strtotime($value));
                    if ($year != $currentYear && $year != $nextYear) {
                        $fail('The start date must be within '.$currentYear.' or '.$nextYear);
                    }
                }
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date',
                function ($attribute, $value, $fail) use ($currentYear, $nextYear) {
                    $year = date('Y', strtotime($value));
                    if ($year != $currentYear && $year != $nextYear) {
                        $fail('The end date must be within '.$currentYear.' or '.$nextYear);
                    }
                }
            ],
            'tournament_date' => [
                'required',
                'date',
                'after:end_date',
                function ($attribute, $value, $fail) use ($currentYear, $nextYear) {
                    $year = date('Y', strtotime($value));
                    if ($year != $currentYear && $year != $nextYear) {
                        $fail('The tournament date must be within '.$currentYear.' or '.$nextYear);
                    }
                }
            ],
            'time' => 'required|date_format:H:i',
            'participant_option' => 'required|in:preset,custom',
            'max_participants' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->participant_option === 'preset' && !in_array($value, [8, 16, 32, 64, 128])) {
                        $fail('The selected number of participants is invalid for preset option.');
                    }
                    if ($request->participant_option === 'custom' && ($value < 9 || $value > 256)) {
                        $fail('Custom participants must be between 9 and 256.');
                    }
                },
            ],
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'prizes' => 'nullable|string',
        ]);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // ✅ Handle cropped image OR fallback to normal file
        $bannerPath = null;

        if ($request->has('cropped_banner')) {
            $croppedImage = $request->input('cropped_banner');

            // Convert base64 to image
            $croppedImage = str_replace('data:image/jpeg;base64,', '', $croppedImage);
            $croppedImage = base64_decode($croppedImage);
            $bannerName = time() . '.jpg';
            $bannerPath = 'images/tournament_banners/' . $bannerName;
            file_put_contents(public_path($bannerPath), $croppedImage);
        } else {
            // fallback if cropper didn't work
            $bannerName = time().'.'.$request->banner->extension();
            $request->banner->move(public_path('images/tournament_banners'), $bannerName);
            $bannerPath = 'images/tournament_banners/'.$bannerName;
        }


        // ✅ Create tournament
        Tournament::create([
            'name' => $validated['name'],
            'game' => $validated['game'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'tournament_date' => $validated['tournament_date'],
            'time' => $validated['time'],
            'max_participants' => $validated['max_participants'],
            'description' => $validated['description'] ?? null,
            'rules' => $validated['rules'] ?? null,
            'prizes' => $validated['prizes'] ?? null,
            'banner' => $bannerPath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Tournament created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = Tournament::findOrFail($id);

        $participants_count = DB::table('team_tournament')
                                ->where('tournament_id', $tournament->id)
                                ->count();

        $user = Auth::user();
        $ledTeams = collect(); // Inicializa como uma coleção vazia
        $subscribedLedTeam = null;

        if ($user) {
            $ledTeams = $user->ledTeams()->get(); // Assumes ledTeams() relationship exists on User model

            if ($ledTeams->isNotEmpty()) {
                // Check if any of the user's led teams are in this tournament using the pivot table
                $subscribedTeamIdsForThisTournament = DB::table('team_tournament')
                                                        ->where('tournament_id', $tournament->id)
                                                        ->pluck('team_id')
                                                        ->all(); // Get an array of team_ids

                foreach ($ledTeams as $team) {
                    if (in_array($team->id, $subscribedTeamIdsForThisTournament)) {
                         $subscribedLedTeam = $team;
                         break;
                    }
                }
            }
        }

        // Carrega a view com os dados necessários
         return view('tournaments.show', [
            'tournament' => $tournament,
            'participants_count' => $participants_count, // Pass the directly calculated count
            'ledTeams' => $ledTeams,
            'subscribedLedTeam' => $subscribedLedTeam,
            // 'activeTab' => $activeTab, // If you were using this for tabs on this page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tournament = Tournament::findOrFail($id);
        return view('tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tournament = Tournament::findOrFail($id);

        // Authorization
        if (auth()->id() !== $tournament->user_id && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(403, 'Unauthorized action. You do not have permission to update this tournament.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'rules'       => 'nullable|string',
            'prizes'       => 'nullable|string',
            'banner'      => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $dataToUpdate = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'rules'       => $validated['rules'] ?? null,
            'prizes'       => $validated['prizes'] ?? null,
        ];

        $publicBaseDirectory = 'images/tournament_banners/'; // Relative to public_path()

        // Handle banner upload
        if ($request->hasFile('banner')) {
            // 1. Delete the old banner if it exists
            if ($tournament->banner && file_exists(public_path($tournament->banner))) {
                unlink(public_path($tournament->banner));
            }

            // 2. Store the new banner
            $bannerFile = $request->file('banner');
            // Create a unique name for the banner
            $bannerName = time() . '_' . uniqid() . '.' . $bannerFile->getClientOriginalExtension();
            // Move the uploaded file to public/images/tournament_banners/
            $bannerFile->move(public_path($publicBaseDirectory), $bannerName);
            // Store the path relative to the public directory for easy use with asset()
            $dataToUpdate['banner'] = $publicBaseDirectory . $bannerName; // e.g., "images/tournament_banners/12345_abc.jpg"

        } elseif ($request->filled('remove_banner') && $request->input('remove_banner') == '1') {
            // Optional: if you add a checkbox named 'remove_banner' with value '1' to delete the banner
            if ($tournament->banner && file_exists(public_path($tournament->banner))) {
                unlink(public_path($tournament->banner));
            }
            $dataToUpdate['banner'] = null;
        }
        // If no new banner is uploaded and 'remove_banner' is not used,
        // $dataToUpdate will not contain the 'banner' key.
        // Eloquent's update() method will only update fields present in $dataToUpdate,
        // so the existing $tournament->banner value in the DB should remain unchanged.

        $tournament->update($dataToUpdate);

        return redirect()->route('tournaments.show', $tournament)
                        ->with('success', 'Tournament updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tournament = Tournament::findOrFail($id);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the banner image
        Storage::disk('public')->delete($tournament->banner);
        
        $tournament->delete();

        return redirect()->route('dashboard')
                        ->with('success', 'Tournament deleted successfully!');
    }

    public function subscribeTeam(Request $request, Tournament $tournament)
    {
        $request->validate(['team_id' => 'required|exists:teams,id']);
        $teamToSubscribe = Team::findOrFail($request->team_id);
        $user = Auth::user();

        // 1. Verify user is the leader of the team
        if (!$user->ledTeams()->where('teams.id', $teamToSubscribe->id)->exists()) {
            return back()->with('error', 'Você não é o líder desta equipe.');
        }

        // 2. Check if the team is already subscribed
        if ($tournament->teams->contains($teamToSubscribe->id)) {
            return back()->with('info', 'Sua equipe já está inscrita neste torneio.');
        }

        // 3. CRUCIAL: Verify no member of the selected team is already in this tournament with another team
        //    vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
        $incomingTeamUserIds = $teamToSubscribe->members()->pluck('users.id')->toArray(); // CORRECTED
        //    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

        // Get all user IDs from teams already in the tournament
        $usersInTournament = collect();
        foreach ($tournament->teams as $subscribedTeam) { // $subscribedTeam is an instance of Team
            //    vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
            $usersInTournament = $usersInTournament->merge($subscribedTeam->members()->pluck('users.id')); // CORRECTED: members() and pluck('id')
            //    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        }
        $usersInTournament = $usersInTournament->unique();

        $conflictingUserIds = array_intersect($incomingTeamUserIds, $usersInTournament->all());

        if (!empty($conflictingUserIds)) {
            $conflictingUsers = User::whereIn('id', $conflictingUserIds)->pluck('name')->join(', ');
            return back()->with('error', "Não é possível inscrever a equipe. O(s) jogador(es): {$conflictingUsers} já está(ão) inscrito(s) neste torneio com outra equipe.");
        }

        

        if ($tournament->teams()->count() >= $tournament->max_participants) {
            return back()->with('error', 'Este torneio já atingiu o número máximo de equipes inscritas.');
        }

        $activeMemberCount = $teamToSubscribe->activeMembers()->count();

        if ($activeMemberCount < $tournament->min_team_size) {
            return back()->with('error', "A equipe '{$teamToSubscribe->name}' não tem o mínimo de 5 jogadores ativos.");
        }

        // Subscribe the team
        $tournament->teams()->attach($teamToSubscribe->id);

        return back()->with('success', "A equipe '{$teamToSubscribe->name}' foi inscrita com sucesso no torneio!");
    }

    public function unsubscribeTeam(Request $request, Tournament $tournament, Team $team)
    {
        $user = Auth::user();

        // 1. Verify user is the leader of the team
        // Example: if ($team->leader_id !== $user->id && !$user->ledTeams()->where('teams.id', $team->id)->exists()) {
        if (!$user->ledTeams()->where('teams.id', $team->id)->exists()) {
            return back()->with('error', 'Você não é o líder desta equipe para cancelar a inscrição.');
        }

        // 2. Check if the team is actually subscribed
        if (!$tournament->teams->contains($team->id)) {
            return back()->with('info', 'Esta equipe não está inscrita neste torneio.');
        }

        // 3. Unsubscribe the team
        $tournament->teams()->detach($team->id);

        return back()->with('success', "A inscrição da equipe '{$team->name}' foi cancelada.");
    }
}