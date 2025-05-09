<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TournamentController;
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

// Public Tournament Listing
Route::get('/tournaments', [TournamentController::class, 'index'])
    ->name('tournaments.index');

Route::get('/tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');