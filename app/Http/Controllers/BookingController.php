<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show all rooms for booking (student view)
    public function booking()
    {
        $rooms = Room::all(); // fetch all rooms
        $user = Auth::user();

        // Check if user already has an active booking
        $hasActiveBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['Approved', 'Paid'])
            ->exists();

        return view('booking', compact('rooms', 'hasActiveBooking'));
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

    // Store a new booking (student booking a room)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id'
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $user = Auth::user();

        // Gender check: prevent male/female mismatch
        if ($room->gender !== 'Mixed' && $room->gender !== $user->gender) {
            return back()->with('error', 'This room is for ' . $room->gender . ' only.');
        }

        // Availability check
        if (!$room->available) {
            return back()->with('error', 'This room is not available.');
        }

        // Prevent multiple active bookings
        $hasActiveBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['Approved', 'Paid'])
            ->exists();

        if ($hasActiveBooking) {
            return back()->with('error', 'You already have an active booking.');
        }

        // Create booking
        Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'booking_date' => now(),
            'status' => 'Pending',
        ]);

        // Optional: mark room as unavailable
        $room->update(['available' => false]);

            // Approve this booking
    $booking->status = 'Approved';
    $booking->due_date = now()->addMonth(); // next month
    $booking->save();

    $user->notify(new PaymentDue($booking));

        return redirect()->route('booking')->with('success', 'Room booked successfully!');
    }

    // Show student booking page with rooms and user's bookings
    public function create()
    {
        $rooms = Room::all();

        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->latest()
            ->get();

        // Check if the student has an active booking
        $hasActiveBooking = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['Approved', 'Paid'])
            ->exists();

        return view('student.booking', compact('rooms', 'bookings', 'hasActiveBooking'));
    }
}