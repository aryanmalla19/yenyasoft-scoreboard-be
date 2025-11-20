<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\Player;
use App\Models\Team;

class PlayerService
{
    public function getAll()
    {
        return Player::simplePaginate(10);
    }

    // Only players NOT yet registered to any team in active league
    public function availablePlayers()
    {
        return Player::whereNull('team_id')->simplePaginate(10);
    }

    public function create(array $data): Player
    {
        return Player::create($data);
    }

    public function update(array $data, Player $player): bool
    {
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
