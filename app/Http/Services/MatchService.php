<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Enums\MatchEventType;
use App\Enums\MatchStatus;
use App\Events\FoulCommitted;
use App\Events\GoalScored;
use App\Events\HalfTimeStarted;
use App\Events\MatchEnded;
use App\Events\MatchStarted;
use App\Models\MatchModal;
use App\Models\Player;
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
        $match = $league->matches()->create([
            'status' => MatchStatus::LIVE->value,
            ...$data
        ]);

        $event = $match->events()->create([
            'type' => MatchEventType::MATCH_START->value,
            'league_id' => $league->id,
        ]);

        broadcast(new MatchStarted($match, $event));
        return $match;
    }

    public function goal(MatchModal $match, array $data): MatchModal
    {
        $player = Player::findOrFail($data['player_id']);
        $team = $player->team;

        $team->id === $match->home_team_id ? $match->increment('home_score') : $match->increment('away_score');

        $team->increment('score');

        $player->increment('total_goals');

        $event = $match->events()->create([
            'type' => MatchEventType::GOAL->value,
            'value' => 1,
            'league_id' => $team->league_id,
            'team_id' => $team->id,
            'player_id' => $data['player_id'],
        ]);

        $event->load('match');

        broadcast(new GoalScored($event));

        return $match;
    }

    public function foul(MatchModal $match, array $data): MatchModal
    {
        $player = Player::findOrFail($data['player_id']);

        $player->increment('total_fouls');

        $event = $match->events()->create([
            'type' => MatchEventType::FOUL->value,
            'value' => 1,
            'league_id' => $match->league_id,
            'team_id' => $player->team_id,
            'player_id' => $player->id,
        ]);

        broadcast(new FoulCommitted($event));

        return $match;
    }

    public function halftimeStart(MatchModal $match): MatchModal
    {
        $match->update([
            'is_halftime' => true,
            'status' => MatchStatus::HALFTIME->value,
        ]);

        $event = $match->events()->create([
            'type' => MatchEventType::HALFTIME->value,
            'league_id' => $match->league_id,
        ]);

        broadcast(new HalfTimeStarted($match, $event));

        return $match;
    }

    public function halftimeEnd(MatchModal $match): MatchModal
    {
        $match->update([
            'is_halftime' => false,
            'status' => MatchStatus::HALFTIME->value,
        ]);

        return $match;
    }

    public function end(MatchModal $match): MatchModal
    {
        $match->update([
            'status' => MatchStatus::FINISHED,
        ]);

        $event = $match->events()->create([
            'type' => MatchEventType::MATCH_END->value,
            'league_id' => $match->league_id,
        ]);

        broadcast(new MatchEnded($match, $event));

        return $match;
    }

    public function redCard(array $data, MatchModal $match): MatchModal
    {
        $player = Player::findOrFail($data['player_id']);

        $player->increment('total_fouls');


        $match->events()->create([
            'type' => MatchEventType::RED_CARD->value,
            'league_id' => $match->league_id,
        ]);
        return $match;
    }

    public function yellowCard(array $data, MatchModal $match): MatchModal
    {
        $player = Player::findOrFail($data['player_id']);

        $player->increment('total_fouls');

        $match->events()->create([
            'type' => MatchEventType::RED_CARD->value,
            'league_id' => $match->league_id,
        ]);
        return $match;
    }
}
