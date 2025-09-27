<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'event_id', 'ticket_id', 'quantity', 
        'total_amount', 'status', 'date'
    ];

    // العلاقة: الحجز ينتمي إلى مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة: الحجز ينتمي إلى فعالية
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // العلاقة: الحجز ينتمي إلى تذكرة
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}