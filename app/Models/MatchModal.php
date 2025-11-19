<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchModal extends Model
{
    protected $table = "matches";

    protected $fillable = [
        'status',
        'halftime_duration',
        'is_halftime',
        'start_time',
        'end_time',
        'home_score',
        'away_score',
        'league_id',
        'home_team_id',
        'away_team_id',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'match_id');
    }
}
