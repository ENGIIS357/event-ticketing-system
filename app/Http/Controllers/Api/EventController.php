<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    // جلب كل الفعاليات
   public function index(): JsonResponse
{
    $events = Event::with('user:id,name')->get();

    // إضافة معرف المستخدم الحالي
    $currentUserId = auth()->check() ? auth()->id() : null;

    return response()->json([
        'events' => $events,
        'current_user_id' => $currentUserId
    ], 200);
}
public function uploadImage(Request $request, Event $event)
{
    $request->validate(['image' => 'required|image|max:2048']);
    $path = $request->file('image')->store('events', 'public');
    $event->image = $path;
    $event->save();
    return response()->json($event, 200);
}


    // إنشاء فعالية جديدة
    public function store(Request $request): JsonResponse
    {
        Log::info('محاولة إضافة فعالية جديدة', [
            'user' => $request->user() ? $request->user()->id : 'غير مسجل',
            'data' => $request->all()
        ]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'price' => 'required|numeric|min:0',
                'available_tickets' => 'required|integer|min:1',
            ]);

            $userId = $request->user() ? $request->user()->id : 1;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('events', 'public');
                $validated['image'] = $path;
            }

            $event = Event::create(array_merge($validated, ['user_id' => $userId]));

            Log::info('تم إنشاء الفعالية بنجاح', ['event_id' => $event->id]);

            return response()->json([
                'message' => 'تمت إضافة الفعالية بنجاح!',
                'event' => $event->load('user:id,name')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('خطأ في التحقق: ' . json_encode($e->errors()));
            return response()->json([
                'message' => 'خطأ في التحقق من البيانات',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('خطأ في الخادم: ' . $e->getMessage());
            return response()->json([
                'message' => 'خطأ في الخادم: ' . $e->getMessage()
            ], 500);
        }
    }

    // عرض فعالية محددة
    public function show(Event $event): JsonResponse
    {
        $event->load('user:id,name', 'tickets');
        return response()->json(['event' => $event], 200);
    }

    // تعديل فعالية
   public function update(Request $request, Event $event): JsonResponse
{
    $validatedData = $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'start_date' => 'sometimes|date',
        'end_date' => 'sometimes|date|after_or_equal:start_date',
        'location' => 'sometimes|string|max:255',
        'price' => 'sometimes|numeric|min:0',
        'available_tickets' => 'sometimes|integer|min:1',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('events', 'public');
        $validatedData['image'] = $path;
    }

    $event->update($validatedData);

    return response()->json([
        'message' => 'تم تعديل الفعالية بنجاح!',
        'event' => $event
    ], 200);
}


    // حذف فعالية
    public function destroy(Request $request, Event $event): JsonResponse
    {
        try {
            $event->delete();
            return response()->json(['message' => 'تم حذف الفعالية بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'خطأ في الخادم: ' . $e->getMessage()
            ], 500);
        }
    }
}
