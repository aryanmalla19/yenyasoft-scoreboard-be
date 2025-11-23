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
            'league' => new LeagueResource($this->whenLoaded('league')),
            'match' => new MatchResource($this->whenLoaded('match')),
            'team' => new TeamResource($this->whenLoaded('team')),
            'player' => new PlayerResource($this->whenLoaded('player')),
            'event_by' => $this->match
                ? ($this->team_id === $this->match->home_team_id ? 'home' : 'away')
                : null,
        ];
    }
}
