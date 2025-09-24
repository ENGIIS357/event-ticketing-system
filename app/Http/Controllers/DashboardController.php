<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات Dashboard
        $stats = [
            'total_events' => Event::count(),
            'total_users' => User::count(),
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::with('event')->get()->sum(function($booking) {
                return $booking->event ? $booking->event->price * $booking->quantity : 0;
            }),
            'recent_events' => Event::with('user')->latest()->take(5)->get()
        ];

        return view('dashboard', compact('stats'));
    }
}