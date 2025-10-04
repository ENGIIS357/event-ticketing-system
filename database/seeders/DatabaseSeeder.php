<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء 10 مستخدمين
        $users = User::factory(10)->create();

        // إضافة فعاليات تجريبية يدوياً لكل مستخدم
        $users->each(function ($user) {
            // إنشاء 1-3 فعاليات لكل مستخدم
            $eventsCount = rand(1, 3);
            
            for ($i = 0; $i < $eventsCount; $i++) {
                $event = Event::create([
                    'title' => 'فعالية ' . ($i + 1) . ' للمستخدم ' . $user->name,
                    'description' => 'وصف تفصيلي لفعالية ' . ($i + 1) . ' للمستخدم ' . $user->name,
                    'start_date' => now()->addDays(rand(7, 30)),
                    'end_date' => now()->addDays(rand(31, 90)),
                    'location' => 'موقع الفعالية ' . ($i + 1),
                    'price' => rand(10, 100),
                    'available_tickets' => rand(50, 200),
                    'user_id' => $user->id
                ]);

                // إنشاء 1-3 تذاكر لكل فعالية
                $ticketsCount = rand(1, 3);
                for ($j = 0; $j < $ticketsCount; $j++) {
                    Ticket::create([
                        'event_id' => $event->id,
                        'type' => 'نوع ' . ($j + 1),
                        'price' => $event->price + rand(0, 20),
                        'quantity' => rand(10, 50)
                    ]);
                }
            }
        });

        // رسالة تأكيد
        $this->command->info('تم إنشاء ' . Event::count() . ' فعالية و ' . Ticket::count() . ' تذكرة بنجاح!');
    }
}