<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class StudentBookingController extends Controller
{
    public function index()
    {
        // Fetch all available rooms
        $rooms = Room::all();

        // Fetch all bookings by the current student
        $bookings = Auth::user()->bookings()->with('room')->get();

        // Fetch the approved room via the User relationship
        $room = Auth::user()->approvedRoom; // returns Room or null

        return view('student.booking', compact('rooms', 'bookings', 'room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'status'  => 'pending', // default status
        ]);

        return redirect()->route('student.booking')->with('success', 'Booking request submitted!');
    }

    /**
 * Get all bookings of the user
 */
public function bookings()
{
    return $this->hasMany(Booking::class);
}
    /**
     * Get the approved room via booking
     */
    public function approvedRoom()
    {
        return $this->hasOneThrough(
            Room::class,      // Final model
            Booking::class,   // Intermediate model
            'user_id',        // Foreign key on bookings table
            'id',             // Foreign key on rooms table
            'id',             // Local key on users table
            'room_id'        // Local key on bookings table
        )->where('bookings.status', 'approved');
    }   
}
