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

        // لكل مستخدم، إنشاء 1-3 فعاليات
        $users->each(function ($user) {
            $events = Event::factory()
                ->count(random_int(1, 3))
                ->for($user) // ربط الفعالية بالمستخدم
                ->create();

            // لكل فعالية، إنشاء 1-3 أنواع تذاكر
            $events->each(function ($event) {
                Ticket::factory()
                    ->count(random_int(1, 3))
                    ->for($event) // ربط التذكرة بالفعالية
                    ->create();
            });
        });

        // (Optional) يمكنك إنشاء بعض الحجوزات هنا أيضًا باستخدام BookingFactory
        // \App\Models\Booking::factory(50)->create();
    }
}