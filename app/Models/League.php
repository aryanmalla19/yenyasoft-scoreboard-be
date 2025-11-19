<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'description',
        'duration',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
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
