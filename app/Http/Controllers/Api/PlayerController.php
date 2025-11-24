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
        try {
            $players = $this->playerService->getAll();
            return PlayerResource::collection($players);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request)
    {
        try {
            $data = $request->validated();
            $player = $this->playerService->create($data);

            return new PlayerResource($player);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
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
        try {
            $data = $request->validated();

            $this->playerService->update($data, $player);

            return new PlayerResource($player->refresh());
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        try {
            $player->delete();
            return $this->successResponse("Successfully deleted player");
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function available()
    {
        try {
            $players = $this->playerService->availablePlayers();

            return PlayerResource::collection($players);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
