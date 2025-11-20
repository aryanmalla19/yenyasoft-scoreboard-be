<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Http\Services\PlayerService;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct(public readonly PlayerService $playerService)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = $this->playerService->getAll();
        return PlayerResource::collection($players);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request)
    {
        $data = $request->validated();
        $player = $this->playerService->create($data);

        return new PlayerResource($player);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return new PlayerResource($player);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayerRequest $request, Player $player)
    {
        $data = $request->validated();

        $this->playerService->update($data, $player);

        return new PlayerResource($player->refresh());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player->delete();
    }

    public function available()
    {
        $players = $this->playerService->availablePlayers();
        return PlayerResource::collection($players);
    }
}
