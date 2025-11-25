<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'value' => $this->value,
            'league' => $this->league ? new LeagueResource($this->league) : null,
            'match' => $this->match ? new MatchResource($this->match) : null,
            'team' => $this->team ? new TeamResource($this->team) : null,
            'player' => $this->player ? new PlayerResource($this->player) : null,
            'live_time_minutes' => $this->match ? (int) $this->match->start_time->diffInMinutes($this->created_at) : null,
            'event_by' => $this->match
                ? ($this->team_id === $this->match->home_team_id ? 'home' : 'away')
                : null,
        ];
    }

}
