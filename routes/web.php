<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| هنا الروتات الخاصة بالويب.
|
*/

// الصفحة الرئيسية
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// لوحة التحكم
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ملفات البروفايل (تحت auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// صفحات التجربة / اختبار
Route::get('/test-page', function () {
    return Inertia::render('TestPage');
});

Route::get('/test-simple', function () {
    return view('test-simple');
});

// ==================================================
// مسارات الفعاليات تحت auth + verified
// ==================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // قائمة الفعاليات
    Route::get('/events', function () {
        return Inertia::render('Events/Index');
    })->name('events.index');

    // إنشاء فعالية جديدة
    Route::get('/events/create', function () {
        return Inertia::render('Events/Create');
    })->name('events.create');

    // تخزين فعالية جديدة
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // صفحة الطلبات (Orders)
    // Route::get('/orders', function () {
    //     return Inertia::render('Events/Index');
    // })->name('orders');
});

// ==================================================
// مسارات API بديلة في web.php
// ==================================================
Route::get('/api/test', function () {
    return response()->json(['message' => 'API is working from web.php!']);
});

Route::get('/api/v1/simple-test', function () {
    return response()->json(['message' => 'V1 is working from web.php!']);
});

// API Events
Route::get('/api/v1/events', [EventController::class, 'index']);
Route::get('/api/v1/events/{event}', [EventController::class, 'show']);
// حل بديل لـ API routes
Route::post('/api/v1/events', [App\Http\Controllers\Api\EventController::class, 'store']);
// حذف حدث (auth:sanctum)
Route::middleware('auth:sanctum')->delete('/api/v1/events/{event}', [EventController::class, 'destroy']);

// استدعاء auth routes
require __DIR__.'/auth.php';
