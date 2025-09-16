<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // جلب جميع الفعاليات مع علاقاتها (مثل المستخدم) باستخدام التحميل المبكر
        $events = Event::with('user:id,name')->get(); // جلب فقط id و name من المستخدم

        return response()->json([
            'events' => $events
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // تحقق من صحة البيانات
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1'
        ]);
        // التحقق من الصلاحية
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'price' => 'required|numeric|min:0',
        'available_tickets' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // معالجة رفع الصورة
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
        $validated['image'] = $imagePath;
    }

    // إنشاء الفعالية
    $event = $request->user()->events()->create($validated);

    return response()->json([
        'message' => 'تم إنشاء الفعالية بنجاح',
        'event' => $event
    ], 201);


        // إنشاء الفعالية وربطها بالمستخدم المسجل حالياً
        $event = $request->user()->events()->create($validatedData);

        return response()->json([
            'message' => 'Event created successfully!',
            'event' => $event
        ], 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): JsonResponse
    {
        // جلب الفعالية مع علاقاتها
        $event->load('user:id,name', 'tickets');

        return response()->json([
            'event' => $event
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): JsonResponse
    {
        // تحقق من الصلاحية - فقط صاحب الفعالية يمكنه التعديل
        // (سيتم تطبيق Politices بشكل كامل لاحقاً)
        if ($request->user()->id !== $event->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'location' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'available_tickets' => 'sometimes|integer|min:1'
        ]);

        $event->update($validatedData);

        return response()->json([
            'message' => 'Event updated successfully!',
            'event' => $event
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Event $event): JsonResponse
    {
        // تحقق من الصلاحية - فقط صاحب الفعالية يمكنه الحذف
        if ($request->user()->id !== $event->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully!'
        ], 200); // أو 204 No Content
        
    }
}
