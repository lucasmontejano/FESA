<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ProfileNavigationController;
use App\Models\Tournament;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Route (with tournaments data)
Route::get('/dashboard', function () {
    $tournaments = Tournament::with('creator')->latest()->get();
    return view('dashboard', compact('tournaments'));
})->middleware('auth')->name('dashboard');

// Tournament Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('tournaments', TournamentController::class)->except(['index']);
});

Route::get('/tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');
Route::put('/tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
Route::delete('/tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');


// Team Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/teams/{team}/invite', [TeamController::class, 'generateInviteUrl'])->name('teams.generateInviteUrl');
    Route::get('/teams/join/{token}', [TeamController::class, 'join'])->name('teams.join');
    Route::get('/teams/{team}/manage', [TeamController::class, 'manage'])->name('teams.manage');
    Route::put('/teams/{team}/members/{member}/role', [TeamController::class, 'updateMemberRole'])->name('teams.updateMemberRole');
    Route::delete('/teams/{team}/members/{member}/remove', [TeamController::class, 'removeMember'])->name('teams.removeMember');
    Route::post('/teams/{team}/invite', [TeamController::class, 'generateInviteUrl'])->name('teams.generateInviteUrl');
    Route::get('/team-invite/{token}', [TeamController::class, 'showInvite'])->name('teams.showInvite');
    Route::post('/team-invite/{token}', [TeamController::class, 'acceptInvite'])->name('teams.acceptInvite');
    Route::post('/teams/{team}/positions', [TeamController::class, 'updatePositions'])->name('teams.updatePositions');
});

// Profile Routes
Route::get('/users/{user:name}', [ProfileController::class, 'show'])->name('users.show');
Route::middleware(['auth'])->group(function () {
    Route::put('/profile/update-picture', [ProfileController::class, 'update'])->name('profile.updatePicture');
    Route::put('/profile/update-description', [ProfileController::class, 'update'])->name('profile.updateDescription');
});

Route::post('/tournaments/{tournament}/subscribe-team', [TournamentController::class, 'subscribeTeam'])
    ->name('tournaments.subscribeTeam')
    ->middleware('auth');

Route::delete('/tournaments/{tournament}/unsubscribe-team/{team}', [TournamentController::class, 'unsubscribeTeam'])
    ->name('tournaments.unsubscribeTeam')
    ->middleware('auth');

Route::get('/tournaments/{tournament}/bracket', [TournamentController::class, 'showBracket'])->name('tournaments.bracket')->middleware('auth');

// In routes/web.php
Route::get('/matches/{match}', [MatchController::class, 'show'])->name('matches.show')->middleware('auth');