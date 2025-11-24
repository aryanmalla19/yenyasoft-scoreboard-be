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
        try {
            $teams = $this->leagueService->getTeams($league);

            return TeamResource::collection($teams);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreTeamRequest $request, League $league)
    {
        try {
            $data = $request->validated();
            $team = $this->leagueService->storeTeam($data, $league);

            return new TeamResource($team);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
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
        try {
            $data = $request->validated();
            $this->leagueService->updateTeam($data, $team);

            return new TeamResource($team->refresh());
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        try {
            $team->delete();

            return $this->successResponse("Successfully delete a team");
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
