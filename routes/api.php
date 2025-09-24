<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;

Route::prefix('v1')->group(function () {
    // جلب كل الفعاليات
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    // إضافة فعالية
    Route::post('/events', [EventController::class, 'store']);

    // تحديث فعالية (PUT و PATCH)
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::patch('/events/{event}', [EventController::class, 'update']);

    // حذف فعالية
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
    Route::middleware('auth:sanctum')->delete('/api/v1/events/{event}', [EventController::class, 'destroy']);

});
Route::post('/events/{event}/upload', [EventController::class, 'uploadImage']);
