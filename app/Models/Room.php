<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

// app/Models/Room.php
protected $fillable = [
    'room_number', 'room_floor', 'gender', 'bedspace', 
    'status', 'rent_fee', 'description', 'image'
];

   // Room.php
public function bookings()
{
    return $this->hasMany(Booking::class);
}

// Room.php
public function students()
{
    return $this->hasManyThrough(
        User::class,
        Booking::class,
        'room_id', // booking.room_id
        'id',      // user.id
        'id',      // room.id
        'user_id'  // booking.user_id
    )->whereHas('bookings', function($query) {
        $query->where('status', 'approved'); // only count approved bookings
    });
}


}
