<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use Illuminate\Support\Facades\Storage;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = Tournament::latest()->get();
        return view('tournaments.index', ['tournaments' => $tournaments]);
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
            'prize' => 'nullable|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $bannerName = time().'.'.$request->banner->extension();
        $request->banner->move(public_path('images/tournament_banners'), $bannerName);
        $bannerPath = 'images/tournament_banners/'.$bannerName;

        Tournament::create([
            'name' => $validated['name'],
            'game' => $validated['game'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'tournament_date' => $validated['tournament_date'],
            'time' => $validated['time'],
            'max_participants' => $validated['max_participants'],
            'description' => $validated['description'],
            'rules' => $validated['rules'],
            'prize' => $validated['prize'],
            'banner' => $bannerPath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tournaments.index')
                        ->with('success', 'Tournament created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = Tournament::findOrFail($id);
        return view('tournaments.show', compact('tournament'));
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
            'banner' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $data = [
            'name' => $validated['name'],
            'game' => $validated['game'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'tournament_date' => $validated['tournament_date'],
            'max_participants' => $validated['max_participants'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('banner')) {
            Storage::disk('public')->delete($tournament->banner);
            $data['banner'] = $request->file('banner')->store('tournament_banners', 'public');
        }

        $tournament->update($data);

        return redirect()->route('dashboard')
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
}