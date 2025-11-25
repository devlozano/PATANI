<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show room booking page
    public function booking()
    {
        $rooms = Room::all(); // all rooms
        return view('booking', compact('rooms'));
    }

    // Admin: Show all bookings
    public function index()
    {
        $pending = Booking::where('status', 'pending')
            ->with(['user', 'room'])
            ->get();

        $all = Booking::with(['user', 'room'])->get();

        return view('admin.booking', compact('pending', 'all'));
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

    // Show student booking page with rooms and user's bookings
    public function create()
    {
        $rooms = Room::all();

        // ✅ Eager load room for user's bookings
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->latest()
            ->get();

        return view('student.booking', compact('rooms', 'bookings'));
    }
}
