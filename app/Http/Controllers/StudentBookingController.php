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
        $user = Auth::user();

        // Fetch all available rooms
        $rooms = Room::all();

        // Fetch all bookings by the current student
        $bookings = $user->bookings()->with('room')->get();

        // Check if the student has an approved or paid booking
        $hasActiveBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['Approved', 'Paid'])
            ->exists();

        return view('student.booking', compact('rooms', 'bookings', 'hasActiveBooking'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Fetch all bookings and rooms for display
        $bookings = $user->bookings()->with('room')->get();
        $rooms = Room::all();

        // Check if the student has an approved or paid booking
        $hasActiveBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['Approved', 'Paid'])
            ->exists();

        return view('student.dash', compact('bookings', 'rooms', 'hasActiveBooking'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Prevent booking if student already has an active booking
        $hasActiveBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['Approved', 'Paid'])
            ->exists();

        if ($hasActiveBooking) {
            return redirect()->back()->with('error', 'You already have an active booking. Please wait until you are checked out.');
        }

        // 2. Validate inputs
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_number' => 'required|string',
        ]);

        // 3. ✅ GENDER RESTRICTION LOGIC
        // Fetch the room details
        $room = Room::findOrFail($request->room_id);

        // Normalize string case (e.g., "Male" vs "male") to ensure accurate comparison
        $userGender = strtolower($user->gender); 
        $roomGender = strtolower($room->gender);

        // Check restriction:
        // If room is NOT 'mixed' AND room gender does NOT match user gender
        if ($roomGender !== 'mixed' && $roomGender !== $userGender) {
            return redirect()->back()->with('error', 'You cannot book this room. It is designated for ' . ucfirst($roomGender) . 's only.');
        }

        // 4. Create Booking if checks pass
        Booking::create([
            'user_id'    => $user->id,
            'room_id'    => $request->room_id,
            'bed_number' => $request->bed_number,
            'status'     => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Booking request sent successfully!');
    }
}