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
        'ticket_number',
        'event_id', 
        'user_id',
        'type',
        'price',
        'status',
        'qr_code'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * العلاقة مع الفعالية
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * إنشاء رقم تذكرة تلقائي
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = 'TKT-' . strtoupper(uniqid());
            }
        });
    }
}