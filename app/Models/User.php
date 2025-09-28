<?php

// namespace App\Models;

// // use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable
// {
//     /** @use HasFactory<\Database\Factories\UserFactory> */
//     use HasFactory, Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var list<string>
//      */
//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//     ];

//     /**
//      * The attributes that should be hidden for serialization.
//      *
//      * @var list<string>
//      */
//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     /**
//      * Get the attributes that should be cast.
//      *
//      * @return array<string, string>
//      */
//     protected function casts(): array
//     {
//         return [
//             'email_verified_at' => 'datetime',
//             'password' => 'hashed',
//         ];
//     }
// }


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <--- هذا الصحيح
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasRoles; 

    // باقي الكود

// ... الكود الحالي

class User extends Authenticatable
{use HasFactory;
 use HasFactory, Notifiable, HasRoles;

    // السماح بعمل Mass Assignment على الحقول دي
    protected $fillable = [
        'name',
        'email',
        'password',
         'role',
        // أضف أي حقول تانية محتاج تعمل عليها mass assignment
    ];
    // العلاقة: المستخدم لديه العديد من الفعاليات (كمُنظم)
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // العلاقة: المستخدم لديه العديد من الحجوزات (كحضور)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // دالة مساعدة: التحقق إذا كان المستخدم منظم فعاليات
    public function isOrganizer()
    {
        return $this->events()->exists();
    }

    // دالة مساعدة: عدد الفعاليات التي نظمها
    public function eventsCount()
    {
        return $this->events()->count();
    }

    // دالة مساعدة: عدد التذاكر التي اشتراها
    public function ticketsCount()
    {
        return $this->bookings()->sum('quantity');
    }
    // علاقة المستخدم مع الإشعارات
    
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }
}