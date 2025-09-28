<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * عرض قائمة التذاكر مع الإحصائيات
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // الإحصائيات
            $stats = [
                'totalTickets' => Ticket::count(),
                'reservedTickets' => Ticket::where('status', 'reserved')->count(),
                'availableTickets' => Ticket::where('status', 'available')->count(),
                'totalRevenue' => Ticket::where('status', 'confirmed')->sum('price')
            ];

            // التذاكر مع العلاقات
            $tickets = Ticket::with(['event', 'user:id,name,email'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // الفعاليات للفلتر
            $events = Event::select('id', 'title')->get();

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'tickets' => $tickets,
                'events' => $events
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في تحميل التذاكر',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض تذكرة محددة
     */
    public function show(Ticket $ticket): JsonResponse
    {
        try {
            $ticket->load(['event', 'user']);

            return response()->json([
                'success' => true,
                'ticket' => $ticket
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في تحميل التذكرة',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث حالة التذكرة
     */
    public function update(Request $request, Ticket $ticket): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:reserved,confirmed,cancelled,pending,available'
            ]);

            $ticket->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة التذكرة بنجاح',
                'ticket' => $ticket->load(['event', 'user'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في تحديث التذكرة',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف التذكرة
     */
    public function destroy(Ticket $ticket): JsonResponse
    {
        try {
            $ticket->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف التذكرة بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في حذف التذكرة',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * تصدير التذاكر
     */
    public function export(Request $request): JsonResponse
    {
        try {
            $tickets = Ticket::with(['event', 'user'])
                ->when($request->status, function($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($request->event_id, function($query, $eventId) {
                    return $query->where('event_id', $eventId);
                })
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'تم تجهيز البيانات للتصدير',
                'count' => $tickets->count(),
                'data' => $tickets
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في تصدير البيانات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات التذاكر
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total' => Ticket::count(),
                'by_status' => Ticket::selectRaw('status, count(*) as count')
                    ->groupBy('status')
                    ->get(),
                'by_event' => Ticket::join('events', 'tickets.event_id', '=', 'events.id')
                    ->selectRaw('events.title, count(*) as count, sum(tickets.price) as revenue')
                    ->groupBy('events.id', 'events.title')
                    ->get(),
                'revenue_by_month' => Ticket::where('status', 'confirmed')
                    ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, sum(price) as revenue')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في تحميل الإحصائيات',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}