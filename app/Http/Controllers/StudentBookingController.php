<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment; // Ensure Payment model is imported if used
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

        // Fetch all bookings for the history table (latest first)
        $bookings = $user->bookings()->with('room')->latest()->get(); 
        
        // Fetch all payments (optional, if you use $payments in dash view)
        $payments = Payment::where('user_id', $user->id)->latest()->get();

        // Get announcements (optional, if you use $announcements in dash view)
        $announcements = \App\Models\Announcement::latest()->take(5)->get();

        // ✅ FIX: Get the single "Active" booking for the "My Room" card
        // Priority order: Approved/Occupied/Paid > Pending > Rejected/Cancelled
        $currentBooking = $user->bookings()
            ->whereIn('status', ['Approved', 'Occupied', 'Paid'])
            ->with('room')
            ->latest()
            ->first();

        // If no active booking, check for a pending one
        if (!$currentBooking) {
            $currentBooking = $user->bookings()
                ->where('status', 'Pending')
                ->with('room')
                ->latest()
                ->first();
        }

        // If still no booking, just get the very last one (likely cancelled/rejected)
        if (!$currentBooking) {
            $currentBooking = $user->bookings()->with('room')->latest()->first();
        }

        return view('student.dash', compact('bookings', 'payments', 'announcements', 'currentBooking'));
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
        $room = Room::findOrFail($request->room_id);

        // Normalize string case
        $userGender = strtolower($user->gender); 
        $roomGender = strtolower($room->gender);

        // Check restriction:
        if ($roomGender !== 'mixed' && $roomGender !== $userGender) {
            return redirect()->back()->with('error', 'You cannot book this room. It is designated for ' . ucfirst($roomGender) . 's only.');
        }

        // 4. Create Booking
        Booking::create([
            'user_id'    => $user->id,
            'room_id'    => $request->room_id,
            'bed_number' => $request->bed_number,
            'status'     => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Booking request sent successfully!');
    }
}