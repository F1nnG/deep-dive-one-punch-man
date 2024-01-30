<?php

namespace App\Console\Commands;

use App\Jobs\PlanBattles as PlanBattlesJob;
use Illuminate\Console\Command;

class PlanBattles extends Command
{
    protected $signature = 'battles:plan';

    protected $description = 'Try to plan all battle requests';

    public function handle(): void
    {
        PlanBattlesJob::dispatch();
    }
}
