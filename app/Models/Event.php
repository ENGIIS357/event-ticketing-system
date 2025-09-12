<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // أضف هذا السطر
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory; // أضف هذا السطر
   public function user() {
    return $this->belongsTo(User::class);
}
public function tickets() {
    return $this->hasMany(Ticket::class);
}
public function bookings() {
    return $this->hasMany(Booking::class);
}
}
