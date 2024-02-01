<?php

namespace Database\Seeders;

use App\Models\AttackType;
use App\Models\Power;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        collect([User::factory()->asHero()->create(), User::factory()->asMonster()->create()])
            ->each(function (User $user) {
                $user->statistic()->save(
                    Statistic::factory()->cleanStats()->make(),
                );
                $user->powers()->saveMany(
                    Power::factory()->count(3)->make([
                        'attack_type_id' => 1,
                    ])->each(function (Power $power) {
                        $power->attack_type_id = AttackType::inRandomOrder()->first()->id;
                    }),
                );
            });
    }
}
