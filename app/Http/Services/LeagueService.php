<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\League;
use App\Models\Team;

readonly class LeagueService
{
    public function __construct(
        protected TeamService $teamService,
        protected FileService $fileService,
    )
    {}

    public function getAll()
    {
        return League::withCount(['matches', 'teams'])->simplePaginate(10);
    }

    public function activeLeagues()
    {
        return League::where('is_active', true)
            ->simplePaginate(10);
    }

    /**
     * @throws \Exception
     */
    public function create(array $data): League
    {
        if(request()->hasFile('logo')){
            $data['logo'] = $this->fileService->uploadFile('logo', 'images');
        }
        $league = League::create($data);

        if($league->start >= now() && $league->end_date <= now()){
            $this->activate($league);
        }

        return $league;
    }

    public function update(array $data, League $league): bool
    {
        return $league->update($data);
    }

    public function activate(League $league): bool
    {
        return $league->update([
            'is_active' => true,
        ]);
    }

    public function deactivate(League $league): bool
    {
        return $league->update([
            'is_active' => false,
        ]);
    }

    public function getTeams(League $league)
    {
        return Team::where('league_id', $league->id)
            ->simplePaginate(10);
    }

    public function storeTeam(array $data, League $league): Team
    {
        return $league->teams()->create($data);
    }

    public function updateTeam(array $data, Team $team): bool
    {
        return $team->update($data);
    }
}
