
<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\NotificationController;

Route::prefix('v1')->group(function () {
    // Events
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    // Tickets
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index']);
});

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

// use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::get('/tickets', [TicketController::class, 'index']);
//     Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
//     Route::post('/tickets/export', [TicketController::class, 'export']);
// });
// // إشعارات
//     Route::prefix('notifications')->group(function () {
//         Route::get('/', [NotificationController::class, 'index']);
//         Route::get('/unread-count', [NotificationController::class, 'getUnreadCount']);
//         Route::post('/{notification}/read', [NotificationController::class, 'markAsRead']);
//         Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
//         Route::delete('/{notification}', [NotificationController::class, 'destroy']);
//     });