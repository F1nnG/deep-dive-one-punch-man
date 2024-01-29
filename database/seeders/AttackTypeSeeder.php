<?php

namespace Database\Seeders;

use App\Models\AttackType;
use Illuminate\Database\Seeder;

class AttackTypeSeeder extends Seeder
{
    public function run(): void
    {
        $attackTypes = collect(json_decode(file_get_contents(storage_path('app/attack_types.json')), true));

        $attackIds = $attackTypes->pluck('id')->toArray();
        if (AttackType::whereIn('id', $attackIds)->exists()) {
            return;
        }

        $attackTypes->each(function ($attackType) {
            AttackType::factory()->create($attackType);
        });
    }
}
