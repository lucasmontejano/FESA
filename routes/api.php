<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TournamentStatusController;

// Rota para o usuário autenticado (padrão do Laravel)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route::get('/tournaments/{tournament}/status', [TournamentStatusController::class, 'show']);
 */