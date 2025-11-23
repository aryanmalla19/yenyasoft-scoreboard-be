<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\StoreMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Http\Resources\MatchResource;
use App\Http\Services\MatchService;
use App\Models\MatchModal;
use Illuminate\Http\Request;
use Mockery\Exception;

class MatchController extends Controller
{
    public function __construct(private readonly MatchService $matchService)
    {}

    public function index()
    {
        try {
            $matches = $this->matchService->getAll();
            return MatchResource::collection($matches);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the current matches.
     */
    public function current()
    {
        try {
            $matches = $this->matchService->currentLiveGames();

            return MatchResource::collection($matches);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchRequest $request)
    {
        try {
            $data = $request->validated();
            $match = $this->matchService->store($data);

            return new MatchResource($match);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchModal $match)
    {
        try {
            $match->loadMissing(['events.player', 'events.match', 'homeTeam.players', 'awayTeam.players', 'league']);
            return new MatchResource($match);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function goal(StoreEventRequest $request, MatchModal $match)
    {
        try {
            $data = $request->validated();
            $this->matchService->goal($match, $data);

            return $this->successResponse("Successfully scored a goal");
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function foul(StoreEventRequest $request, MatchModal $match)
    {
        try{
            $data = $request->validated();
            $this->matchService->foul($match, $data);

            return $this->successResponse("Successfully given a Foul");
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function halftimeStart(MatchModal $match)
    {
        try {
            $this->matchService->halftime($match);

            return $this->successResponse("Halftime successfully started");
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function halftimeEnd(MatchModal $match)
    {
        try {
            $this->matchService->halftime($match);

            return $this->successResponse("Halftime started and Match Started");
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function end(MatchModal $match)
    {
        try {
            $this->matchService->end($match);

            return $this->successResponse("The Match has Ended");
        }catch (Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function redCard(StoreEventRequest $request, MatchModal $match)
    {
        try {
            $data = $request->validated();
            $this->matchService->end($match);

            return $this->successResponse("The Match has Ended");
        }catch (Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function yellowCard(StoreEventRequest $request, MatchModal $match)
    {
        try {
            $data = $request->validated();
            $this->matchService->end($match);

            return $this->successResponse("The Match has Ended");
        }catch (Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
