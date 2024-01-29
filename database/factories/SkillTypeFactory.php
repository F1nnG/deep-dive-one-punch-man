<?php

namespace Database\Factories;

use App\Models\SkillType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillTypeFactory extends Factory
{
    protected $model = SkillType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
