<?php

namespace App\Console\Commands;

use App\Enums\MatchStatus;
use App\Http\Services\MatchService;
use App\Models\MatchModal;
use Illuminate\Console\Command;

class CheckMatchStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:match-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check status of matches';

    /**
     * Execute the console command.
     */
    public function handle(MatchService $matchService): void
    {
        $matches = MatchModal::wherePast('start_time')
            ->where('status', MatchStatus::NOT_STARTED->value)
            ->get();

        foreach ($matches as $match) {
            $match->update([
                'status' => MatchStatus::LIVE->value,
            ]);
            $this->info("Match {$match->id} status: LIVE");
        }

        $matches = MatchModal::whereFuture('end_time')
            ->whereNot('status', MatchStatus::FINISHED->value)
            ->get();

        foreach ($matches as $match) {
            $matchService->end($match);
            $this->info("Match {$match->id} status: LIVE");
        }
    }
}
