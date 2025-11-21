<?php

namespace App\Http\Controllers\Api;

use App\Enums\MatchStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeagueResource;
use App\Http\Resources\MatchResource;
use App\Models\League;
use App\Models\MatchModal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $liveMatches = MatchModal::whereIn('status', [MatchStatus::LIVE->value, MatchStatus::HALFTIME->value])
            ->get();
        $upcomingMatches = MatchModal::where('status', MatchStatus::NOT_STARTED->value)
            ->get();
        $leagues = League::get();

        return $this->customResponse([
            'live_matches' => MatchResource::collection($liveMatches),
            'upcoming_matches' => MatchResource::collection($upcomingMatches),
            'leagues' => LeagueResource::collection($leagues),
        ]);
    }
}
