<?php

namespace App\Console\Commands;

use App\Jobs\DemoJob;
use Illuminate\Console\Command;

class StartDemo extends Command
{
    protected $signature = 'demo:start';

    protected $description = 'Start the demo to show the application in action';

    public function handle(): void
    {
        DemoJob::dispatch();
    }
}
