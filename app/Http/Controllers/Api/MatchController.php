<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Http\Resources\MatchResource;
use App\Http\Services\MatchService;
use App\Models\MatchModal;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function __construct(private readonly MatchService $matchService)
    {}

    /**
     * Display a listing of the current matches.
     */
    public function current()
    {
        $matches = $this->matchService->currentLiveGames();

        return MatchResource::collection($matches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchRequest $request)
    {
        $data = $request->validated();
        $match = $this->matchService->store($data);

        return new MatchResource($match);
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchModal $match)
    {
        return new MatchResource($match->loadMissing(['events', 'homeTeam', 'awayTeam', 'league']));
    }

    public function goal(UpdateMatchRequest $request, MatchModal $match)
    {
        $data = $request->validated();
        $this->matchService->goal($match, $data);
    }

    public function foul(UpdateMatchRequest $request, MatchModal $match)
    {
        $data = $request->validated();
        $this->matchService->foul($match, $data);
    }

    public function halftime(MatchModal $match)
    {
        $this->matchService->halftime($match);
    }

    public function end(MatchModal $match)
    {
        $this->matchService->end($match);
    }
}
