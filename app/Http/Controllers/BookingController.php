<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    
        public function booking()
    {
        $rooms = Room::all(); // assuming you have a Room model
        return view('booking', compact('rooms'));
    }

    // Show all available rooms and user's bookings
    public function index()
    {
        $rooms = Room::all();
        $bookings = Booking::where('user_id', Auth::id())->get();
        return view('booking', compact('rooms', 'bookings'));
    }

    // Handle booking a room
    public function store(Request $request)
    {
        $request->validate(['room_id' => 'required|exists:rooms,id']);

        $room = Room::findOrFail($request->room_id);

        if (!$room->available) {
            return back()->with('error', 'This room is not available.');
        }

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'booking_date' => now(),
            'status' => 'Pending',
        ]);

        // Optional: mark room as unavailable
        $room->update(['available' => false]);

        return redirect()->route('booking')->with('success', 'Room booked successfully!');
    }
}
