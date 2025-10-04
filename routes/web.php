<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Foundation\Application;
//use App\Http\Controllers\EventController; // 👈 مو Api\EventController
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketsManagementController;
//use App\Http\Controllers\TicketController;
//use App\Http\Controllers\Api\V1\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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

// ==================================================
// مسارات المصادقة والملف الشخصي
// ==================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================================================
// مسارات التطبيق الرئيسية (تحت المصادقة والتحقق)
// ==================================================
Route::middleware(['auth', 'verified'])->group(function () {

     // لوحة التحكم الرئيسية
     Route::get('/dashboard', function () {
         return Inertia::render('Dashboard');
     })->name('dashboard');

    // قائمة الفعاليات
    Route::get('/events', function () {
        return Inertia::render('Events/Index');
    })->name('events.index');

    // إنشاء فعالية جديدة
    Route::get('/events/create', function () {
        return Inertia::render('Events/Create');
    })->name('events.create');

    // عرض فعالية واحدة
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // تعديل فعالية (تحقق من المالك داخل الـ Controller)
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');

    // تخزين فعالية جديدة
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // تحديث فعالية
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');

    // حذف فعالية
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // إدارة التذاكر (صفحة مؤقتة)
    Route::get('/tickets', function () {
        return Inertia::render('Tickets/Index', [
            'message' => 'صفحة التذاكر قيد التطوير'
        ]);
    })->name('tickets.index');

    // إدارة المستخدمين (صفحة مؤقتة)
    Route::get('/users', function () {
        return Inertia::render('Users/Index', [
            'message' => 'صفحة المستخدمين قيد التطوير'
        ]);
    })->name('users.index');
});

// ==================================================
// مسارات API في web.php (كبديل عن routes/api.php)
// ==================================================
Route::group(['prefix' => 'v1'], function () {

    // Public routes (Read)
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    // Protected routes (Create, Update, Delete) - Require authentication
        Route::middleware('auth:sanctum')->group(function () {
        Route::post('/events', [EventController::class, 'store']);
        // Route::put('/events/{event}', [EventController::class, 'update']);
        // Route::patch('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);
        Route::put('/events/{id}', [EventController::class, 'update']);   // ✨ أضف هذا
        Route::patch('/events/{id}', [EventController::class, 'update']); // 
        //Route::put('/events/{event}', [EventController::class, 'update']);

    });
});

// ==================================================
// مسارات API بديلة إضافية
// ==================================================
Route::get('/api/test', function () {
    return response()->json(['message' => 'API is working from web.php!']);
});

Route::get('/api/v1/simple-test', function () {
    return response()->json(['message' => 'V1 is working from web.php!']);
});

Route::get('/api/v1/events', [EventController::class, 'index']);
Route::get('/api/v1/events/{event}', [EventController::class, 'show']);
Route::post('/api/v1/events', [EventController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/api/v1/events/{event}', [EventController::class, 'destroy']);
Route::post('/events/{event}/upload', [EventController::class, 'uploadImage']);

// ==================================================
// مسارات التطوير والاختبار
// ==================================================
Route::get('/test-page', function () {
    return Inertia::render('TestPage');
});

Route::get('/test-simple', function () {
    return view('test-simple');
});


// ==================================================
// استدعاء routes المصادقة (Laravel Breeze)
// ==================================================
require __DIR__.'/auth.php';

// ==================================================
// Fallback
// ==================================================
Route::fallback(function () {
    return redirect('/dashboard');
});
Route::get('/v1/events-json', [EventController::class, 'apiIndex']);
Route::get('/v1/events-json/{event}', [EventController::class, 'apiShow']);

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('tickets', TicketController::class);
    
    Route::get('/events', function () {
        return Inertia::render('Events/Index');
    })->name('events.index');
    
    Route::get('/reports', function () {
        return Inertia::render('Reports/Index');
    })->name('reports');
});
Route::get('/tickets', function () {
    return Inertia::render('Tickets/Index');
})->name('tickets.index');
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index']);
});
Route::get('/tickets-management', function () {
    // جلب البيانات مباشرة من الكونترولر
    $controller = new TicketController();
    $response = $controller->index(request());
    
    // إرجاع البيانات للواجهة
    return Inertia::render('Tickets/Index', [
        'ticketsData' => $response->getData()
    ]);
})->name('tickets.management');
Route::get('/tickets-management', [
    TicketsManagementController::class,
     'index'])->name('tickets.management');


     Route::get('/tickets-management', function () {
    // جلب البيانات مباشرة
    $stats = [
        'totalTickets' => \App\Models\Ticket::count(),
        'reservedTickets' => \App\Models\Ticket::where('status', 'reserved')->count(),
        'availableTickets' => \App\Models\Ticket::where('status', 'available')->count(),
        'totalRevenue' => \App\Models\Ticket::where('status', 'confirmed')->sum('price')
    ];

    $tickets = \App\Models\Ticket::with(['event', 'user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $events = \App\Models\Event::select('id', 'title')->get();

    return \Inertia\Inertia::render('Tickets/Index', [
        'ticketsData' => [
            'success' => true,
            'stats' => $stats,
            'tickets' => $tickets,
            'events' => $events
        ]
    ]);
})->name('tickets.management');
// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::get('/tickets', [TicketController::class, 'index']);
//     Route::get('/tickets/stats', [TicketController::class, 'stats']);
//     Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
//     Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
//     Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);
//     Route::post('/tickets/export', [TicketController::class, 'export']);
// });
//  Route::prefix('notifications')->group(function () {
//         Route::get('/', [NotificationController::class, 'index']);
//         Route::get('/unread-count', [NotificationController::class, 'getUnreadCount']);
//         Route::post('/{notification}/read', [NotificationController::class, 'markAsRead']);
//         Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
//         Route::delete('/{notification}', [NotificationController::class, 'destroy']);
//     });
    