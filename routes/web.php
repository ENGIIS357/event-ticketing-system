<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// routes/api.php

use App\Http\Controllers\Api\EventController;

// Group routes under /api/v1 prefix for versioning
Route::group(['prefix' => 'v1'], function () {
    // Public routes (Read)
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    // Protected routes (Create, Update, Delete) - Require authentication
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/events', [EventController::class, 'store']);
        Route::put('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);
    });
});



Route::get('/events', function () {
    return Inertia::render('Events/Index');
})->middleware(['auth', 'verified'])->name('events.index');

require __DIR__.'/auth.php';

// ==============================================
// مسارات API بديلة (لحل مشكلة routes/api.php)
// ==============================================

Route::get('/api/test', function () {
    return response()->json(['message' => 'API is working from web.php!']);
});

Route::get('/api/v1/simple-test', function () {
    return response()->json(['message' => 'V1 is working from web.php!']);
});

Route::get('/api/v1/events', [App\Http\Controllers\Api\EventController::class, 'index']);
Route::get('/api/v1/events/{event}', [App\Http\Controllers\Api\EventController::class, 'show']);

Route::get('/events', function () {
    return inertia('Events/Index');
})->middleware(['auth', 'verified'])->name('events.index');