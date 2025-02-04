<?php

namespace RomanStruk\ManticoreScoutEngine\Tests\TestModels;

use Illuminate\Database\Eloquent\Factories\Factory;

class SimilarProductFactory extends Factory
{
    protected $model = SimilarProduct::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
        ];
    }
}
