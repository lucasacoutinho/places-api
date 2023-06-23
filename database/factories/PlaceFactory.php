<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->words(2, true),
        ];
    }
}
