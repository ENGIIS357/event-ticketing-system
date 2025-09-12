<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 week', '+1 month');
        $endDate = clone $startDate;
        $endDate->modify('+'. $this->faker->numberBetween(1, 5) .' hours');

        return [
            'user_id' => User::factory(), // سيُنشئ user تلقائيًا
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $this->faker->address,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'available_tickets' => $this->faker->numberBetween(50, 200),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'event', true), // صورة وهمية اختيارية
        ];
    }
}