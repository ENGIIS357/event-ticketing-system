<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Event extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'title',
//         'description',
//         'location',
//         'start_date',
//         'end_date',
//         'price',
//         'available_tickets',
//         'image',
//         'user_id',
//     ];

//     // التحويل التلقائي للتواريخ إلى Carbon
//     protected $casts = [
//         'start_date' => 'date',
//         'end_date'   => 'date',
//         'price'      => 'decimal:2',
//     ];

//     // العلاقات
//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function tickets()
//     {
//         return $this->hasMany(Ticket::class);
//     }

//     public function bookings()
//     {
//         return $this->hasMany(Booking::class);
//     }
// 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'location', 'start_date', 
        'end_date', 'price', 'available_tickets', 'user_id', 'image'
    ];

    // العلاقة: الفعالية تنتمي إلى مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة: الفعالية لها العديد من التذاكر
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // العلاقة: الفعالية لها العديد من الحجوزات
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}