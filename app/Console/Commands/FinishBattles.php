<?php

namespace App\Console\Commands;

use App\Jobs\FinishBattles as FinishBattlesJob;
use Illuminate\Console\Command;

class FinishBattles extends Command
{
    protected $signature = 'battles:finish';

    protected $description = 'Finish all battles that have been completed';

    public function handle(): void
    {
        FinishBattlesJob::dispatch();
    }
}
