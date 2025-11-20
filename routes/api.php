<?php

use App\Http\Controllers\Api\LeagueController;
use App\Http\Controllers\Api\PlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('leagues', LeagueController::class)
    ->names('leagues');

Route::apiResource('players', PlayerController::class)
    ->names('players');
