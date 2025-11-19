<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'type',
        'value',
        'league_id',
        'match_id',
        'team_id',
        'player_id',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(MatchModal::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function player(): ?BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
