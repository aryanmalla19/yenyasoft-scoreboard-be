<?php

namespace App\Http\Controllers\Api;

use App\Enums\MatchStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeagueResource;
use App\Http\Resources\MatchResource;
use App\Models\League;
use App\Models\MatchModal;
use Illuminate\Http\Request;
use Mockery\Exception;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $liveMatches = MatchModal::with(['homeTeam', 'awayTeam'])
                ->whereIn('status', [MatchStatus::LIVE->value, MatchStatus::HALFTIME->value])
                ->get();
            $upcomingMatches = MatchModal::with(['awayTeam', 'homeTeam', 'league'])
                ->where('status', MatchStatus::NOT_STARTED->value)
                ->get();
            $leagues = League::withCount(['teams', 'matches'])->get();

            return $this->customResponse([
                'live_matches' => MatchResource::collection($liveMatches),
                'upcoming_matches' => MatchResource::collection($upcomingMatches),
                'leagues' => LeagueResource::collection($leagues),
            ]);
        }catch (Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
