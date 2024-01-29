<?php

namespace Database\Seeders;

use App\Models\Power;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();

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
        });
    }
}
