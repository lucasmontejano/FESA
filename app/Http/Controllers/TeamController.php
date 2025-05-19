<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\TeamInvite;
use App\Models\User;

class TeamController extends Controller
{   
    use AuthorizesRequests;
    /**
     * Show the form for creating a new team.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team = new Team();
        $team->name = $request->name;

        if ($request->hasFile('picture')) {
            $imageName = time().'.'.$request->picture->extension();
            $request->picture->move(public_path('images/team_pictures'), $imageName);
            $team->picture = $imageName;
        }

        $team->leader_id = Auth::id();
        $team->save();

        // Add the leader as an active member of the team
        $team->members()->attach(Auth::id(), ['role' => 'active']);

        return redirect()->route('teams.show', $team->id)->with('success', 'Team created successfully!');
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team)
    {
        $team->load('leader', 'members'); // Eager load leader and members
        return view('teams.show', compact('team'));
    }

    /**
     * Handle a user joining a team via invitation URL.
     */
    public function join(Request $request)
    {
        $token = $request->token;

        // In a real application, you would look up the team based on the token
        // and validate the token (e.g., check for expiration).
        // For this example, we'll assume you have a way to get the team from the token.

        // Assuming you have a way to get the team from the token:
        // $team = Team::where('invite_token', $token)->first();

        // For demonstration purposes, let's assume the token is the team ID for now
        $team = Team::find($token);


        if (!$team) {
            abort(404); // Or redirect to an error page
        }

        $user = Auth::user();

        // Check if the user is already on this team
        if ($team->members->contains($user)) {
            return redirect()->route('teams.show', $team->id)->with('info', 'You are already a member of this team.');
        }

        // Add the user to the team as an active member
        $team->members()->attach($user->id, ['role' => 'active']);

        return redirect()->route('teams.show', $team->id)->with('success', 'You have joined the team successfully!');
    }

    /**
     * Show the form for managing team members and roles.
     */
    public function manage(Team $team)
    {
        // Ensure the authenticated user is the team leader
        if (Auth::id() !== $team->leader_id) {
            abort(403);
        }

        $team->load('members'); // Eager load members
        return view('teams.manage', compact('team'));
    }

    /**
     * Update the role of a team member.
     */
    public function updateMemberRole(Request $request, Team $team, User $member)
    {
        // Ensure the authenticated user is the team leader
        if (Auth::id() !== $team->leader_id) {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:active,backup',
        ]);

        $team->members()->updateExistingPivot($member->id, ['role' => $request->role]);

        return redirect()->route('teams.manage', $team->id)->with('success', 'Member role updated successfully!');
    }

    /**
     * Remove a member from the team.
     */
    public function removeMember(Team $team, User $member)
    {
        // Ensure the authenticated user is the team leader
        if (Auth::id() !== $team->leader_id) {
            abort(403);
        }

        // Prevent the leader from removing themselves
        if (Auth::id() === $member->id) {
            return redirect()->route('teams.manage', $team->id)->with('error', 'You cannot remove yourself from the team.');
        }

        $team->members()->detach($member->id);

        return redirect()->route('teams.manage', $team->id)->with('success', 'Member removed successfully!');
    }

        // app/Http/Controllers/TeamController.php

    public function generateInviteUrl(Team $team)
    {
        $this->authorize('update', $team);
        
        if (!$team->canAddMember()) {
            return response()->json(['error' => 'Team is full (max 7 players)'], 400);
        }

        $invite = TeamInvite::updateOrCreate(
            [
                'team_id' => $team->id,
                'sender_id' => auth()->id()
            ],
            [
                'token' => Str::random(32),
                'expires_at' => now()->addDays(7),
                'max_uses' => null, // Set to a number if you want to limit uses
                'uses' => 0
            ]
        );

        return response()->json([
            'url' => route('teams.acceptInvite', $invite->token),
            'expires' => $invite->expires_at->diffForHumans()
        ]);
    }

    public function acceptInvite($token)
    {
        $invite = TeamInvite::where('token', $token)
                ->where('expires_at', '>', now())
                ->firstOrFail();

        if (!$invite->isValid()) {
            return redirect()->route('teams.index')
                ->with('error', 'Invite is no longer valid or team is full');
        }

        if ($invite->team->members()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('teams.show', $invite->team)
                ->with('info', 'You are already a member of this team');
        }

        // Determine role
        $role = $invite->team->canAddActiveMember() ? 'active' : 'backup';

        // Add user to team
        $invite->team->members()->attach(auth()->id(), [
            'role' => $role,
            'joined_at' => now()
        ]);

        $invite->increment('uses');
        
        // Only delete if we've reached max uses (if set)
        if ($invite->max_uses && $invite->uses >= $invite->max_uses) {
            $invite->delete();
        }

        return redirect()->route('teams.show', $invite->team)
            ->with('success', "You have joined the team as {$role}!");
    }


    public function showInvite($token)
    {
        $invite = TeamInvite::where('token', $token)
                    ->where('expires_at', '>', now())
                    ->firstOrFail();

        return view('teams.invite', compact('invite'));
    }

    public function updatePositions(Request $request, Team $team)
{
    $this->authorize('update', $team);
    
    $memberIds = $request->input('member_ids');
    
    // Update all members to backup first
    $team->members()->updateExistingPivot($memberIds, ['role' => 'backup']);
    
    // Update first 4 members to active
    $activeMembers = array_slice($memberIds, 0, 4);
    $team->members()->updateExistingPivot($activeMembers, ['role' => 'active']);
    
    return response()->json(['success' => true]);
}
}
