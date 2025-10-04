<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'notifications' => $notifications->items(),
            'unread_count' => Auth::user()->unreadNotifications()->count(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ]
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }
        
        $notification->markAsRead();

        return response()->json([
            'message' => 'تم تعليم الإشعار كمقروء',
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json([
            'message' => 'تم تعليم جميع الإشعارات كمقروءة',
            'unread_count' => 0
        ]);
    }

    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }
        
        $notification->delete();

        return response()->json([
            'message' => 'تم حذف الإشعار',
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    public function getUnreadCount()
    {
        return response()->json([
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    }
}