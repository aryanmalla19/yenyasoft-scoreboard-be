<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\Player;
use App\Models\Team;

class PlayerService
{
    public function __construct(public FileService $fileService)
    {}
    public function getAll()
    {
        return Player::with('team')->simplePaginate(10);
    }

    // Only players NOT yet registered to any team in active league
    public function availablePlayers()
    {
        return Player::whereNull('team_id')->simplePaginate(10);
    }

    /**
     * @throws \Exception
     */
    public function create(array $data): Player
    {
        if(request()->hasFile('image')){
            $data['image'] = $this->fileService->uploadFile('image', 'images');
        }
        return Player::create($data);
    }

    /**
     * @throws \Exception
     */
    public function update(array $data, Player $player): bool
    {
        if(request()->hasFile('image')){
            $this->fileService->deleteFile(asset('storage/'.$player->image), 'images');
            $data['image'] = $this->fileService->uploadFile('image', 'images');
        }
        return $player->update($data);
    }

    public function assignTeam(Player $player, Team $team): Player
    {
        return $player->team()->associate($team);
    }

    public function addGoal(Player $player, array $data)
    {
        return $player->events()->create($data);
    }
}
