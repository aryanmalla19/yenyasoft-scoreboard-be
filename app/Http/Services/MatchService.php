<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Enums\MatchEventType;
use App\Enums\MatchStatus;
use App\Models\MatchModal;
use App\Models\Team;

readonly class MatchService
{
    public function getAll()
    {
        return MatchModal::with(['homeTeam', 'awayTeam'])->simplePaginate(10);
    }

    public function currentLiveGames()
    {
        return MatchModal::where('status', MatchStatus::LIVE->value)
            ->get();
    }

    public function store(array $data): MatchModal
    {
        $league = Team::findOrFail($data['home_team_id'])->league;
        return $league->matches()->create([
            'status' => MatchStatus::LIVE->value,
            ...$data
        ]);
    }

    public function goal(MatchModal $match, array $data): MatchModal
    {
        return $match->events()->create([
            'type' => MatchEventType::GOAL->value,
            'value' => 1,
            'league_id' => $match->league_id,
            'team_id' => $data['team_id'],
            'player_id' => $data['player_id'],
        ]);
    }

    public function foul(MatchModal $match, array $data): MatchModal
    {
        return $match->events()->create([
            'type' => MatchEventType::FOUL->value,
            'value' => 1,
            'league_id' => $match->league_id,
            'team_id' => $data['team_id'],
            'player_id' => $data['player_id'],
        ]);
    }

    public function halftime(MatchModal $match): MatchModal
    {
        return $match->events()->create([
            'type' => MatchEventType::HALFTIME->value,
            'league_id' => $match->league_id,
        ]);
    }

    public function end(MatchModal $match): MatchModal
    {
        return $match->events()->create([
            'type' => MatchEventType::MATCH_END->value,
            'league_id' => $match->league_id,
        ]);
    }
}
