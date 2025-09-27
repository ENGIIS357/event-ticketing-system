
<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;

Route::prefix('v1')->group(function () {
    // Events
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    // Tickets
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Events
        Route::post('/events', [EventController::class, 'store']);
        Route::put('/events/{event}', [EventController::class, 'update']);
        Route::patch('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);

        // Tickets
        Route::post('/tickets', [TicketController::class, 'store']);
        Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);

        // Users
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });
    
});
Route::get('/events-json', [EventController::class, 'apiIndex']);
Route::get('/events-json/{event}', [EventController::class, 'apiShow']);

Route::prefix('v1')->group(function () {
    // ... الروابط الحالية
    
    // Dashboard routes
    Route::get('/dashboard/stats', [DashboardController::class, 'index']);
    Route::get('/dashboard/user-stats', [DashboardController::class, 'userDashboard']);
});