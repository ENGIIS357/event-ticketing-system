<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model // تأكد من أن الاسم هو Ticket وليس Event
{
    use HasFactory;

    public function event() {
        return $this->belongsTo(Event::class);
    }
}