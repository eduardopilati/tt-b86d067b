<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'car_id' => Car::factory(),
            'user_id' => User::factory(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('+2 month', '+3 month')->format('Y-m-d'),
        ];
    }
}
