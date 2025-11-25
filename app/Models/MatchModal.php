<?php

namespace App\Models;

use App\Enums\MatchStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchModal extends Model
{
    protected $table = "matches";

    protected $fillable = [
        'status',
        'is_halftime',
        'start_time',
        'end_time',
        'home_score',
        'away_score',
        'league_id',
        'home_team_id',
        'away_team_id',
    ];

    protected $casts = [
        'status' => 'string',
        'is_halftime' => 'bool',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'home_score' => 'int',
        'away_score' => 'int',
        'league_id' => 'int',
        'home_team_id' => 'int',
        'away_team_id' => 'int',
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

    public function isEnded(): bool
    {
        return $this->status === MatchStatus::FINISHED->value;
    }

    public function isHalftime(): bool
    {
        return $this->status === MatchStatus::HALFTIME->value;
    }

}
