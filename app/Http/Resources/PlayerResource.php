<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'image' => !empty($this->image) ? asset('storage/'.$this->image) : asset('default_player_img.png'),
            'total_goals' => $this->total_goals,
            'total_fouls' => $this->total_fouls,
        ];
    }
}
