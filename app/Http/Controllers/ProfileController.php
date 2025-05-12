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
    public function show(User $user)
    {
        // Load the teams the user belongs to
        $user->load('teams');

        // You might also want to load tournaments the user or their teams are in
        // This depends on how you've structured your tournament relationships
        // For example, if a user can join tournaments individually:
        // $user->load('tournaments');
        // If you want to show tournaments of their teams:
        // $user->load('teams.tournaments');

        return view('profile.show', compact('user'));
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
