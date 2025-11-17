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

// Get students through bookings
public function students()
{
    return $this->hasManyThrough(User::class, Booking::class, 'room_id', 'id', 'id', 'user_id');
}


    public function room()
{
    return $this->belongsTo(Room::class);
}



}
