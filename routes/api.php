<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;

// مسار اختبار أساسي
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// مجموعة مسارات v1
Route::prefix('v1')->group(function () {
    // مسار اختبار v1
    Route::get('/simple-test', function () {
        return response()->json(['message' => 'V1 is working!']);
    });
    
    // مسار الفعاليات
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);
});
