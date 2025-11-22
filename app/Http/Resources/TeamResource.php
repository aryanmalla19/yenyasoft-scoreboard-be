<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'logo' => !empty($this->logo) ? asset($this->logo) : asset('default_team_logo.png'),
            'total_wins' => $this->wins,
            'total_draws' => $this->draw,
            'total_losses' => $this->losses,
            'total_score' => $this->score,
            'players' => PlayerResource::collection($this->whenLoaded('players')),
        ];
    }
}
