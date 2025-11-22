<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class League extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'duration',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'logo' => 'string',
        'description' => 'string',
        'duration' => 'int',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'bool',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($league){
            $league->slug = Str::slug($league->name, '-');
        });

        static::updating(function ($league){
            if($league->isDirty('name')){
                $league->slug = Str::slug($league->name, '-');
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
