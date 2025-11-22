<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Team extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'wins',
        'draws',
        'losses',
        'score',
        'league_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($team){
            $team->slug = Str::slug($team->name, '-');
        });

        static::updating(function ($team){
            if ($team->isDirty('name')){
                $team->slug = Str::slug($team->name, '-');
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
