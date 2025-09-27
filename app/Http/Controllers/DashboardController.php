<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        // بيانات تجريبية للاختبار
        $stats = [
            'total_events' => Event::count() ?: 25,
            'active_events' => Event::where('start_date', '>', now())->count() ?: 12,
            'total_tickets' => Ticket::sum('quantity') ?: 500,
            'sold_tickets' => Booking::sum('quantity') ?: 350,
            'total_revenue' => Booking::sum('total_amount') ?: 25000,
            'total_users' => User::count() ?: 150,
        ];

        return response()->json([
            'stats' => $stats,
            'message' => 'بيانات لوحة التحكم'
        ]);
    }

    public function userDashboard(): JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'user_stats' => [
                    'my_events' => 0,
                    'my_active_events' => 0,
                    'my_tickets_sold' => 0,
                    'my_revenue' => 0
                ],
                'upcoming_events' => []
            ]);
        }

        $userStats = [
            'my_events' => Event::where('user_id', $user->id)->count(),
            'my_active_events' => Event::where('user_id', $user->id)
                                ->where('start_date', '>', now())->count(),
            'my_tickets_sold' => Booking::whereHas('event', function($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })->sum('quantity'),
            'my_revenue' => Booking::whereHas('event', function($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })->sum('total_amount'),
        ];

        $upcomingEvents = Event::where('user_id', $user->id)
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        return response()->json([
            'user_stats' => $userStats,
            'upcoming_events' => $upcomingEvents
        ]);
    }
}