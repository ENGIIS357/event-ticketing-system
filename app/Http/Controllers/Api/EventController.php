<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    // جلب كل الفعاليات (Inertia)
    public function index(): JsonResponse
    {
        $events = Event::with('user:id,name')->get();
        $currentUserId = auth()->check() ? auth()->id() : null;

        return response()->json([
            'events' => $events,
            'current_user_id' => $currentUserId
        ], 200);
    }

    // إنشاء فعالية جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
        ]);

        $userId = $request->user()->id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $validated['image'] = $path;
        }

        Event::create(array_merge($validated, ['user_id' => $userId]));

        return redirect()->route('events.index')
                         ->with('success', 'تمت إضافة الفعالية بنجاح!');
    }

    // عرض فعالية محددة (Inertia)
    public function show(Event $event): Response
    {
        $event->load('user:id,name', 'tickets');

        return Inertia::render('Events/Show', [
            'event' => $event
        ]);
    }

    // تعديل فعالية
    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بتعديل هذه الفعالية');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'تم تحديث الفعالية بنجاح');
    }

    // عرض صفحة تعديل الفعالية (Inertia)
    public function edit(Event $event): Response
    {
        $event->load('user:id,name', 'tickets');

        return Inertia::render('Events/Edit', [
            'event' => $event
        ]);
    }

    // حذف فعالية
    public function destroy(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('events.index')
                         ->with('success', 'تم حذف الفعالية بنجاح');
    }

    // ===============================
    // دوال خاصة بالداشبورد (ترجع JSON)
    // ===============================

    public function apiIndex(): JsonResponse
    {
        $events = Event::with('user:id,name')->get();
        $currentUserId = auth()->check() ? auth()->id() : null;

        return response()->json([
            'events' => $events,
            'current_user_id' => $currentUserId
        ]);
    }

    public function apiShow(Event $event): JsonResponse
    {
        $event->load('user:id,name', 'tickets');

        return response()->json([
            'event' => $event
        ]);
    }
}
