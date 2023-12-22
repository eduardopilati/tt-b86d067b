<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'model' => $this->faker->word,
            'brand' => $this->faker->word,
            'plate' => $this->faker->bothify('???####'),
            'year' => Carbon::now()->year - 1,
        ];
    }
}
