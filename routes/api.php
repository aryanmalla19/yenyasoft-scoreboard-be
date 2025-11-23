<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LeagueController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Support\Facades\Route;


// Leagues
Route::get('leagues', [LeagueController::class, 'index'])->name('leagues.index');
Route::get('leagues/{league}', [LeagueController::class, 'show'])->name('leagues.show');
Route::get('leagues/active', [LeagueController::class, 'active'])->name('leagues.active');
Route::get('players', [PlayerController::class, 'index'])->name('players.index');
Route::get('players/{player}', [PlayerController::class, 'show'])->name('players.show');

// Players
Route::get('players/available', [PlayerController::class, 'available'])->name('players.available');

// Teams
Route::get('leagues/{league}/teams', [TeamController::class, 'index'])->name('leagues.teams.index');
Route::get('teams/{team}', [TeamController::class, 'show'])->name('team.show');

// Matches
Route::get('matches', [MatchController::class, 'index'])->name('matches.index');
Route::get('matches/current', [MatchController::class, 'current'])->name('matches.current');
Route::get('matches/{match}', [MatchController::class, 'show'])->name('matches.show');

// Dashboard
Route::get('dashboard', DashboardController::class)->name('api.dashboard');




Route::middleware('auth:sanctum')->group(function () {

    // Leagues
    Route::post('leagues', [LeagueController::class, 'store'])->name('leagues.store');
    Route::put('leagues/{league}', [LeagueController::class, 'update'])->name('leagues.update');
    Route::delete('leagues/{league}', [LeagueController::class, 'destroy'])->name('leagues.destroy');

    // Teams
    Route::post('leagues/{league}/teams', [TeamController::class, 'store'])->name('leagues.teams.store');
    Route::put('teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('teams/{team}', [TeamController::class, 'destroy'])->name('team.destroy');

    // Matches
    Route::post('matches/start', [MatchController::class, 'store'])->name('matches.start');
    Route::patch('matches/{match}/goal', [MatchController::class, 'goal'])->name('matches.goal');
    Route::patch('matches/{match}/foul', [MatchController::class, 'foul'])->name('matches.foul');
    Route::patch('matches/{match}/halftime-start', [MatchController::class, 'halftimeStart'])->name('matches.halftime-start');
    Route::patch('matches/{match}/halftime-end', [MatchController::class, 'halftimeEnd'])->name('matches.halftime-end');
    Route::patch('matches/{match}/red-card', [MatchController::class, 'redCard'])->name('matches.red-card');
    Route::patch('matches/{match}/yellow-card', [MatchController::class, 'yellowCard'])->name('matches.yellow-card');
    Route::patch('matches/{match}/end', [MatchController::class, 'end'])->name('matches.end');

    // Players
    Route::post('players', [PlayerController::class, 'store'])->name('players.store');
    Route::put('players/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('players/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');
});



