<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matchup;

class MatchController extends Controller
{
    public function show(Matchup $match) {
        $match->load(['team1', 'team2', 'tournament']); // Eager load related data
        return view('matches.show', compact('match'));
    }
}
