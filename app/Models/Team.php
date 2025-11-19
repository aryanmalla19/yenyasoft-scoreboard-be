<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'wins',
        'draws',
        'losses',
        'score',
        'league_id',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function homeMatches(): HasMany
    {
        return $this->hasMany(MatchModal::class, 'home_team_id');
    }

    public function awayMatches(): HasMany
    {
        return $this->hasMany(MatchModal::class, 'away_team_id');
    }

    public function matches(): HasMany
    {
        return $this->hasMany(MatchModal::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
