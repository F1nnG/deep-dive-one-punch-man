<?php

namespace App\Helpers;

use App\Models\Battle;
use App\Models\User;
use Illuminate\Support\Arr;

class BattleAlgorithm
{
    public Battle $battle;

    public User $winner;

    public User $loser;

    public function __construct(Battle $battle)
    {
        $this->battle = $battle;
    }

    public function handle(): void
    {
        $this->setWinnerAndLoser();

        $this->updateBattle();

        $this->updateStatistics();
    }

    private function setWinnerAndLoser(): void
    {
        $this->winner = Arr::random([$this->battle->hero, $this->battle->monster]);
        $this->loser = $this->winner->id === $this->battle->hero->id ? $this->battle->monster : $this->battle->hero;
    }

    private function updateBattle(): void
    {
        $this->battle->update([
            'finished_at' => now(),
            'winner_id' => $this->winner->id,
        ]);
    }

    private function updateStatistics(): void
    {
        [$winnerElo, $loserElo] = EloCalculator::getRatings($this->winner->statistic->elo, $this->loser->statistic->elo);

        $this->winner->statistic->update([
            'wins' => $this->winner->statistic->wins + 1,
            'elo' => $winnerElo,
        ]);

        $this->loser->statistic->update([
            'losses' => $this->loser->statistic->losses + 1,
            'elo' => $loserElo,
        ]);
    }
}
