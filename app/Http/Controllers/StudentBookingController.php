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
        $bookings = Booking::where('user_id', Auth::id())->with('room')->get();

        return view('student.booking', compact('rooms', 'bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'status'  => 'pending',
        ]);

        return redirect()->route('student.booking')->with('success', 'Booking request submitted!');
    }
}
