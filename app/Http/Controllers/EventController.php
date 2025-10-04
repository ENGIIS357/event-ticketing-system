<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('user:id,name')->get();

        return Inertia::render('Events/Index', [
            'events' => $events,
            'current_user_id' => auth()->id(),
        ]);
    }

    public function show(Event $event)
    {
        return Inertia::render('Events/Show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event)
    {
        return Inertia::render('Events/Edit', [
            'event' => $event,
        ]);
    }

    public function store(Request $request)
    {
        // تحقق من البيانات
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
        ]);

        $event = Event::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('events.index')
                         ->with('success', 'تمت إضافة الفعالية بنجاح!');
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
                         ->with('success', 'تم تعديل الفعالية بنجاح!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
                         ->with('success', 'تم حذف الفعالية بنجاح!');
    }
}
