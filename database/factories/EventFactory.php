<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+2 months', '+3 months'),
            'location' => $this->faker->address,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'available_tickets' => $this->faker->numberBetween(50, 200),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}