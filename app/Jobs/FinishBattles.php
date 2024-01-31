<?php

namespace App\Jobs;

use App\Models\Battle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class FinishBattles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $battles = Battle::whereNull('finished_at')
            ->whereDate('date', '<', now()->addDays(50))
            ->get();

        $battles->each(function (Battle $battle) {
            $winner = Arr::random([$battle->hero, $battle->monster]);
            $loser = $winner->id === $battle->hero->id ? $battle->monster : $battle->hero;

            $battle->update([
                'finished_at' => now(),
                'winner_id' => $winner->id,
            ]);

            $winner->statistic->update([
                'wins' => $winner->statistic->wins + 1,
                'elo' => $winner->statistic->elo + 40,
            ]);

            $loser->statistic->update([
                'losses' => $loser->statistic->losses + 1,
                'elo' => $loser->statistic->elo - 40,
            ]);
        });
    }
}
