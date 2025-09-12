<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        // للحصول على سعر التذكرة وربطها بحدث
        $ticket = Ticket::factory()->create(); // إنشاء تذكرة أولاً للحصول على سعرها و event_id
        $quantity = $this->faker->numberBetween(1, 4);

        return [
            'user_id' => User::factory(),
            'event_id' => $ticket->event_id, // استخدام event_id من التذكرة
            'ticket_id' => $ticket->id,
            'quantity' => $quantity,
            'total_amount' => $ticket->price * $quantity,
            'status' => $this->faker->randomElement(['confirmed', 'pending', 'cancelled']),
        ];
    }
}