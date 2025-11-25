<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\MatchModal;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            return $this->customResponse([
                'totalLeagues' => League::count(),
                'totalActiveLeagues' => League::where('is_active', true)->count(),
                'totalTeams' => Team::count(),
                'totalPlayers' => Player::count(),
                'totalMatches' => MatchModal::count(),
                'totalMatchesToday' => MatchModal::whereToday('start_time')->count(),
            ]);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
