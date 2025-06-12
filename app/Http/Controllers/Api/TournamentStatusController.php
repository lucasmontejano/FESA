<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentStatusController extends Controller
{
    /**
     * Retorna o status atual de um torneio específico.
     *
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tournament $tournament)
    {
        return response()->json([
            'status' => $tournament->status,
        ]);
    }
}