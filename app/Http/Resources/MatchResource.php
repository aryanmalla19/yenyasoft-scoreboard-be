<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'halftime_duration' => $this->halftime_duration,
            'is_halftime' => $this->is_halftime,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'home_score' => $this->home_score,
            'away_score' => $this->away_score,
            'event_by' => $this->when(
                $this->relationLoaded('match'),
                fn () => $this->team_id == $this->match->home_team_id ? 'home' : 'away'
            ),
            'league' => new LeagueResource($this->whenLoaded('league')),
            'home_team' => new TeamResource($this->whenLoaded('homeTeam')),
            'away_team' => new TeamResource($this->whenLoaded('awayTeam')),
            'events' => EventResource::collection($this->whenLoaded('events')),
        ];
    }
}
