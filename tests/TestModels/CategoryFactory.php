<?php

namespace RomanStruk\ManticoreScoutEngine\Tests\TestModels;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
        ];
    }
}
