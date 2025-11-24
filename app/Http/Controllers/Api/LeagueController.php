<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Http\Resources\LeagueResource;
use App\Http\Services\LeagueService;
use App\Models\League;

class LeagueController extends Controller
{
    public function __construct(public readonly LeagueService $leagueService)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $leagues = $this->leagueService->getAll();

            return LeagueResource::collection($leagues);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeagueRequest $request)
    {
        $data = $request->validated();
        try {
            $league = $this->leagueService->create($data);

            return new LeagueResource($league);
        }catch (\Exception $e){
           return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(League $league)
    {
        try {
            $league->load(['matches', 'teams']);
            $league->loadCount(['teams', 'matches']);

            return new LeagueResource($league);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeagueRequest $request, League $league)
    {
        try {
            $data = $request->validated();
            $this->leagueService->update($data, $league);

            return new LeagueResource($league->refresh());
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(League $league)
    {
        try {
            $league->delete();
            return $this->successResponse("Successfully deleted league");
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function activate(League $league)
    {
        try {
            $this->leagueService->activate($league);
            return $this->successResponse("Successfully activated league");
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function active()
    {
        try {
            $leagues = $this->leagueService->activeLeagues();

            return LeagueResource::collection($leagues);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

}
