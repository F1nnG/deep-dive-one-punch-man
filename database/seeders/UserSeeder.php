<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\Availability;
use App\Models\BattleRequest;
use App\Models\Power;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->asHero()->create();
        User::factory()->asMonster()->create();

        User::factory(10)->create();

        $users = User::all();

        $users->each(function ($user) {
            $user->powers()->saveMany(
                Power::factory(3)->make([
                    'attack_type_id' => 1,
                ])->each(function ($power) {
                    $power->attackType()->associate(fake()->numberBetween(1, 30));
                })
            );

            $user->statistic()->save(
                Statistic::factory()->make()
            );

            $user->battleRequests()->saveMany(
                BattleRequest::factory(3)->make()
            );

            $user->availabilities()->saveMany(
                Availability::factory(1)->make()
            );

            $user->apiKey()->save(
                ApiKey::factory()->make()
            );
        });
    }
}
