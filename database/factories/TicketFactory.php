<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        // أنواع التذاكر الوهمية
        $ticketTypes = ['General Admission', 'VIP', 'Early Bird', 'Student Pass'];
        return [
            'event_id' => Event::factory(),
            'type' => $this->faker->randomElement($ticketTypes),
            'price' => $this->faker->randomFloat(2, 10, 250),
            'quantity' => $this->faker->numberBetween(20, 100),
        ];
    }
}