<?php

namespace App\Console\Commands;

use App\Http\Services\LeagueService;
use App\Models\League;
use Illuminate\Console\Command;

class CheckLeagueStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:league-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check status of leagues';

    /**
     * Execute the console command.
     */
    public function handle(LeagueService $leagueService)
    {
        $leagues = League::wherePast('start_date')
            ->whereFuture('end_date')
            ->where('is_active', false)
            ->get();

        foreach ($leagues as $league) {
            $leagueService->activate($league);
            $this->info("League {$league->name} changed to Active");
        }


        $leagues = League::wherePast('start_date')
            ->wherePast('end_date')
            ->where('is_active', true)
            ->get();

        foreach ($leagues as $league) {
            $leagueService->deactivate($league);
            $this->info("League {$league->name} changed to Not Active");
        }
    }
}
