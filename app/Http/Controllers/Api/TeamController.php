<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Http\Services\LeagueService;
use App\Models\League;
use App\Models\Team;
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
        $teams = $this->leagueService->getTeams($league);

        return TeamResource::collection($teams);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request, League $league)
    {
        $data = $request->validated();
        $team = $this->leagueService->storeTeam($data, $league);

        return new TeamResource($team);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return new TeamResource($team->load('players'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $data = $request->validated();
        $this->leagueService->updateTeam($data, $team);

        return new TeamResource($team->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();
    }
}
