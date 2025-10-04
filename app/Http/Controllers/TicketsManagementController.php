<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Event;
use Inertia\Inertia;

class TicketsManagementController extends Controller
{
    public function index()
    {
        try {
            // جلب البيانات مباشرة من قاعدة البيانات
            $stats = [
                'totalTickets' => Ticket::count(),
                'reservedTickets' => Ticket::where('status', 'reserved')->count(),
                'availableTickets' => Ticket::where('status', 'available')->count(),
                'totalRevenue' => Ticket::where('status', 'confirmed')->sum('price')
            ];

            $tickets = Ticket::with(['event', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $events = Event::select('id', 'title')->get();

            return Inertia::render('Tickets/Index', [
                'ticketsData' => [
                    'success' => true,
                    'stats' => $stats,
                    'tickets' => $tickets,
                    'events' => $events
                ]
            ]);

        } catch (\Exception $e) {
            // في حالة الخطأ، نرجع بيانات فارغة
            return Inertia::render('Tickets/Index', [
                'ticketsData' => [
                    'success' => false,
                    'stats' => [
                        'totalTickets' => 0,
                        'reservedTickets' => 0,
                        'availableTickets' => 0,
                        'totalRevenue' => 0
                    ],
                    'tickets' => ['data' => []],
                    'events' => [],
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }
}