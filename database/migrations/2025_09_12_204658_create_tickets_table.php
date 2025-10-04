<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    public function run()
    {
        // التأكد من وجود فعاليات ومستخدمين أولاً
        $events = Event::all();
        $users = User::all();

        if ($events->isEmpty() || $users->isEmpty()) {
            $this->command->info('لا توجد فعاليات أو مستخدمين! راجع بياناتك أولاً.');
            return;
        }

        $tickets = [];

        // أنواع التذاكر
        $types = ['regular', 'vip', 'premium'];
        $statuses = ['available', 'reserved', 'confirmed', 'cancelled', 'pending'];

        foreach ($events as $event) {
            // إنشاء 5-10 تذكرة لكل فعالية
            $ticketCount = rand(5, 10);

            for ($i = 0; $i < $ticketCount; $i++) {
                $tickets[] = [
                    'event_id' => $event->id,
                    'user_id' => $users->random()->id,
                    'ticket_number' => 'TKT-' . Str::random(8) . '-' . $event->id,
                    'type' => $types[array_rand($types)],
                    'price' => $this->getPriceByType($types[array_rand($types)]),
                    'status' => $statuses[array_rand($statuses)],
                    'booking_date' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // إدخال البيانات
        Ticket::insert($tickets);

        $this->command->info('تم إنشاء ' . count($tickets) . ' تذكرة بنجاح!');
    }

    private function getPriceByType($type)
    {
        return match($type) {
            'regular' => rand(50, 150),
            'vip' => rand(200, 400),
            'premium' => rand(500, 800),
            default => 100,
        };
    }
}