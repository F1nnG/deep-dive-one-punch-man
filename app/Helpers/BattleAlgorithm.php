<?php

namespace App\Helpers;

use App\Enums\Grade;
use App\Models\Battle;
use App\Models\Power;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BattleAlgorithm
{
    public Battle $battle;

    public string|User $winner;

    public string|User $loser;

    public array $logs = [];

    private int|float $heroHealth;

    private int|float $monsterHealth;

    private Collection $heroPowers;

    private Collection $monsterPowers;

    public function __construct(Battle $battle)
    {
        $this->battle = $battle;
    }

    public function handle(): void
    {
        $this->simulateBattle();

        $this->updateBattle();

        $this->updateStatistics();
    }

    private function simulateBattle(): void
    {
        [$this->heroHealth, $this->monsterHealth] = [100, 100];
        [$this->heroPowers, $this->monsterPowers] = [$this->battle->hero->powers, $this->battle->monster->powers];

        $round = 1;
        while ($this->heroHealth > 0 && $this->monsterHealth > 0) {
            $this->simulateRound($round);
            $round++;
        }

        if ($this->monsterHealth <= 0 && $this->heroHealth <= 0) {
            $this->winner = 'draw';
            $this->loser = 'draw';
        } else if ($this->heroHealth <= 0) {
            $this->winner = $this->battle->monster;
            $this->loser = $this->battle->hero;
        } else {
            $this->winner = $this->battle->hero;
            $this->loser = $this->battle->monster;
        }
    }

    private function simulateRound(int $round): void
    {
        [$heroPower, $monsterPower] = [$this->heroPowers->random(), $this->monsterPowers->random()];

        $heroDamage = $this->getDamageForPower($heroPower, $this->battle->hero);
        $monsterDamage = $this->getDamageForPower($monsterPower, $this->battle->monster);

        $this->monsterHealth -= $heroDamage;
        $this->heroHealth -= $monsterDamage;

        $this->logs[$round] = [
            'round' => $round,
            'hero_power' => $heroPower->attackType->name,
            'hero_damage' => $heroDamage,
            'monster_power' => $monsterPower->attackType->name,
            'monster_damage' => $monsterDamage,
            'hero_health' => $this->heroHealth,
            'monster_health' => $this->monsterHealth,
        ];
    }

    private function getDamageForPower(Power $power, User $opponent): float|int
    {
        $damage = $power->attackType->damage;

        $damage *= rand(8, 12) / 10;

        if ($power->grade === Grade::Primary) {
            $damage *= rand(14, 16) / 10;
        }

        $effectiveAgainstExists = $opponent->powers()->whereHas('attackType', function (Builder $query) use ($power) {
            $query->where('id', $power->attackType->effective_against);
        });

        $weakAgainstExists = $opponent->powers()->whereHas('attackType', function (Builder $query) use ($power) {
            $query->where('id', $power->attackType->weak_against);
        });

        if ($effectiveAgainstExists) {
            $damage *= rand(14, 16) / 10;
        }

        if ($weakAgainstExists) {
            $damage *= rand(4, 5) / 10;
        }

        return $damage;
    }

    private function updateBattle(): void
    {
        if ($this->winner !== 'draw') {
            $this->battle->update([
                'finished_at' => now(),
                'winner_id' => $this->winner->id,
                'logs' => $this->logs,
            ]);
        } else {
            $this->battle->update([
                'finished_at' => now(),
                'logs' => $this->logs,
            ]);
        }
    }

    private function updateStatistics(): void
    {
        if ($this->winner !== 'draw') {
            [$winnerElo, $loserElo] = EloCalculator::getRatings($this->winner->statistic->elo, $this->loser->statistic->elo);

            $this->winner->statistic->update([
                'wins' => $this->winner->statistic->wins + 1,
                'elo' => $winnerElo,
            ]);

            $this->loser->statistic->update([
                'losses' => $this->loser->statistic->losses + 1,
                'elo' => $loserElo,
            ]);
        } else {
            $this->battle->hero->statistic->update([
                'draws' => $this->battle->hero->statistic->draws + 1,
            ]);

            $this->battle->monster->statistic->update([
                'draws' => $this->battle->monster->statistic->draws + 1,
            ]);
        }
    }
}
