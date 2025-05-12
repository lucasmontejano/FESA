<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updatePicture(Request $request, User $user)
    {
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile_pictures'), $filename);
            $user->profile_picture = $filename;
            $user->save();
        }

        return redirect()->back();
    }

    public function updateDescription(Request $request, User $user)
    {
        $request->validate([
            'description' => 'nullable|string|max:1000',
        ]);

        $user->description = $request->input('description');
        $user->save();

        return redirect()->back();
    }
}
