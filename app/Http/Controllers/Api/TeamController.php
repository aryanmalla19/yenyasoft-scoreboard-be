<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Resources\TeamResource;
use App\Http\Services\LeagueService;
use App\Models\League;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(private readonly LeagueService $leagueService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(League $league)
    {
        $teams = $this->leagueService->getLeagueTeams($league);

        return TeamResource::collection($teams);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request, League $league)
    {
        $data = $request->validated();
        $team = $this->leagueService->storeTeam();

        return new TeamResource($team);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTeamRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
