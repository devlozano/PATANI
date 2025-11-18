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

public function dashboard()
{
    $user = Auth::user();

    // Fetch all bookings and rooms for display
    $bookings = $user->bookings()->with('room')->get();
    $rooms = Room::all();

    // ✅ Check if the student has an approved or paid booking
    $hasActiveBooking = Booking::where('user_id', $user->id)
        ->whereIn('status', ['Approved', 'Paid'])
        ->exists();

    return view('student.dash', compact('bookings', 'rooms', 'hasActiveBooking'));
}

    public function store(Request $request)
{
    $user = Auth::user();

    // ✅ Prevent booking if student already has an approved booking
    $hasActiveBooking = Booking::where('user_id', $user->id)
        ->whereIn('status', ['Approved'])
        ->exists();

    if ($hasActiveBooking) {
        return redirect()->back()->with('error', 'You already have an active booking. Please wait until you are checked out.');
    }

    Booking::create([
        'user_id' => $user->id,
        'room_id' => $request->room_id,
        'status' => 'Pending',
    ]);

    return redirect()->back()->with('success', 'Booking request sent successfully!');
}

public function storeBooking(Request $request)
{
    $user = Auth::user();

    // ✅ Check if student already has an active or paid booking
    $activeBooking = Booking::where('user_id', $user->id)
        ->whereIn('status', ['Approved', 'Paid'])
        ->first();

    if ($activeBooking) {
        return redirect()->back()->with('error', 'You already have an active booking. Please wait until you are checked out by the admin before booking another room.');
    }

    // ✅ Continue with booking creation
    $validated = $request->validate([
        'room_id' => 'required|exists:rooms,id',
    ]);

    Booking::create([
        'user_id' => $user->id,
        'room_id' => $validated['room_id'],
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Your booking request has been submitted.');
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
