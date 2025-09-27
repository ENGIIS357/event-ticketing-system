<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Ticket extends Model // تأكد من أن الاسم هو Ticket وليس Event
// {
//     use HasFactory;

//     public function event() {
//         return $this->belongsTo(Event::class);
//     }
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'type',
        'price', 
        'quantity',
        'date'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'date' => 'datetime'
    ];

    // العلاقة: التذكرة تنتمي إلى فعالية
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // العلاقة: التذكرة لها العديد من الحجوزات
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // دالة مساعدة: عدد التذاكر المباعة
    public function soldCount()
    {
        return $this->bookings()->sum('quantity');
    }

    // دالة مساعدة: التذاكر المتاحة
    public function availableCount()
    {
        return $this->quantity - $this->soldCount();
    }

    // دالة مساعدة: التحقق إذا كانت التذكرة متاحة
    public function isAvailable()
    {
        return $this->availableCount() > 0;
    }
}