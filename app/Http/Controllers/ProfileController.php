<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the specified user profile.
     */
    public function show(Request $request, User $user) // $request is injected
    {
        // Load the teams the user belongs to
        $user->load('teams');
        $user->load(['teams.tournaments']);
        // ... any other data loading ...

        $activeTab = session('profile_active_tab', 'teams');
        $validTabs = ['tournaments', 'teams'];
        if (!in_array($activeTab, $validTabs)) {
            $activeTab = 'tournaments';
        }
        session()->forget('profile_active_tab');

        $tournamentsUserIsIn = collect();

        // Add tournaments from user's teams
        if ($user->relationLoaded('teams')) {
            foreach ($user->teams as $team) {
                // The 'tournaments' relationship on the Team model should already be loaded
                // due to the 'teams.tournaments' in $user->load()
                if ($team->relationLoaded('tournaments')) {
                    foreach ($team->tournaments as $tournament) {
                        // Use put() with the tournament's ID as the key
                        // to ensure each tournament appears only once in the collection,
                        // even if the user is in multiple teams participating in the same tournament.
                        $tournamentsUserIsIn->put($tournament->id, $tournament);
                    }
                }
            }
        }

        // Sort the collected tournaments, for example, by their date
        $myRelevantTournaments = $tournamentsUserIsIn->sortBy(function ($tournament) {
            return $tournament->tournament_date ?? now()->addYears(10); // Sort, handling potential null dates
        });

        // CRITICAL: This line MUST return a Blade view if you are not using Inertia.
        return view('profile.show', compact('user', 'activeTab', 'myRelevantTournaments'));
    }

    /**
     * Show the form for editing the authenticated user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:300',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($user->profile_picture) {
                // Assuming profile pictures are stored in public/images/profile_pictures
                $oldImagePath = public_path('images/profile_pictures/' . $user->profile_picture);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('images/profile_pictures'), $imageName);
            $user->profile_picture = $imageName;
        }

        $user->description = $request->description;
        $user->save();

        return redirect($request->redirect_url ?: route('users.show', $user->name))
        ->with('success', 'Description updated successfully!');
    }
}
