<?php

namespace App\Jobs;

use App\Helpers\BattleAlgorithm;
use App\Models\Battle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FinishBattles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $battles = Battle::whereNull('finished_at')
            ->whereDate('date', '<', now()->addDays(50))
            ->get();

        $battles->each(function (Battle $battle) {
            (new BattleAlgorithm($battle))->handle();
        });
    }
}
