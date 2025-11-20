<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMatchRequest;
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

    }

    /**
     * Display the specified resource.
     */
    public function show(MatchModal $matchModal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MatchModal $matchModal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchModal $matchModal)
    {
        //
    }
}
