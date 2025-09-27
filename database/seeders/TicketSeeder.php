<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $event = Event::first();
        
        if ($event) {
            Ticket::create([
                'event_id' => $event->id,
                'type' => 'VIP',
                'price' => 50,
                'quantity' => 10,
                'date' => now()
            ]);
            
            Ticket::create([
                'event_id' => $event->id, 
                'type' => 'عادي',
                'price' => 25,
                'quantity' => 50,
                'date' => now()
            ]);
        }
    }
}