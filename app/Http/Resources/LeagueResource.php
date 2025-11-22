<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'logo' => !empty($this->logo) ? asset($this->logo) : asset('default_league_logo.png'),
            'description' => $this?->description ?? null,
            'duration_months' => $this->duration,
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'is_active' => $this->is_active,
            'total_teams' => $this->teams_count,
            'total_matches_played' => $this->matches_count,
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
        ];
    }
}
