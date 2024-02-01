<?php

namespace App\Jobs;

use App\Models\AttackType;
use App\Models\Availability;
use App\Models\BattleRequest;
use App\Models\Power;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemoJob
{
    use Dispatchable, SerializesModels;

    private const DEMO_USER_COUNT = 100;

    public function handle(): void
    {
        $this->setupUsers();

        while (true) {
            $this->runDemo();
        }
    }

    private function runDemo(): void
    {
        User::all()->each(function (User $user) {
            if ($user->availabilities()->count() > 0) {
                return;
            }

            $user->availabilities()->save(
                Availability::factory()->make([
                    'start_date' => now()->subDays(10),
                    'end_date' => now()->subDay(),
                ])
            );
        });

        User::all()->each(function (User $user) {
            $user->battleRequests()->save(
                BattleRequest::factory()->make()
            );
        });

        PlanBattles::dispatchSync();
        FinishBattles::dispatchSync();
    }

    private function setupUsers(): void
    {
        User::whereNot('is_admin', true)->delete();

        User::factory(self::DEMO_USER_COUNT - 2)->create()
            ->each(function (User $user) {
                $user->powers()->saveMany(
                    Power::factory(3)->make([
                        'attack_type_id' => 1,
                    ])->each(function ($power) {
                        $power->attackType()->associate(
                            AttackType::inRandomOrder()->first()
                        );
                    })
                );

                $user->statistic()->save(
                    Statistic::factory()->cleanStats()->make()
                );
            });
    }
}
