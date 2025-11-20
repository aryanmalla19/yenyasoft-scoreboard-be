<?php

use App\Http\Controllers\Api\LeagueController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('leagues', LeagueController::class)
    ->names('leagues');

Route::apiResource('players', PlayerController::class)
    ->names('players');

// Teams
Route::get('leagues/{league}/teams', [TeamController::class, 'index'])
    ->name('leagues.teams.index');

Route::post('leagues/{league}/teams', [TeamController::class, 'store'])
    ->name('leagues.teams.store');

// Match
Route::get('match/current', [MatchController::class, 'current'])
    ->name('leagues.matches.current');

Route::post('match/start', [MatchController::class, 'store'])
    ->name('leagues.matches.start');

Route::patch('match/{match}/goal', [MatchController::class, 'current'])
    ->name('leagues.matches.start');

Route::patch('match/{match}/foul', [MatchController::class, 'current'])
    ->name('leagues.matches.start');

Route::patch('match/{match}/halftime', [MatchController::class, 'current'])
    ->name('leagues.matches.start');

Route::patch('match/{match}/end', [MatchController::class, 'current'])
    ->name('leagues.matches.start');
