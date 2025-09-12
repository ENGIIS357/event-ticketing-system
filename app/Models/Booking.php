<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model // تأكد من أن الاسم هو Booking
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function event() {
        return $this->belongsTo(Event::class);
    }
    
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
}