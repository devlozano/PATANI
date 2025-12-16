<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ IMPORT PDF FACADE

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
        
        // Fetch all payments
        $payments = Payment::where('user_id', $user->id)->latest()->get();

        // Get announcements
        $announcements = \App\Models\Announcement::latest()->take(5)->get();

        // Get the single "Active" booking for the "My Room" card
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

        // If still no booking, just get the very last one
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

        // 3. GENDER RESTRICTION LOGIC
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

    // ✅ FIXED: GENERATE PDF CONTRACT
    public function generateContract($id)
    {
        // 1. Find the booking (Removed the strict 'where user_id' check so Admins can find it too)
        $booking = Booking::with(['user', 'room'])->findOrFail($id);

        // 2. Security Check: Allow if Owner OR Admin
        $user = Auth::user();
        
        // Assuming your users table has a 'role' column or you have an isAdmin() helper
        // If not, standard role check:
        if ($booking->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // 3. Ensure status is Approved before allowing download
        if (strtolower($booking->status) !== 'approved') {
            return redirect()->back()->with('error', 'Contract is only available for approved bookings.');
        }

        // 4. Load View and Download
        $pdf = Pdf::loadView('pdf.contract', compact('booking'));
        
        return $pdf->download('Patani_Contract_' . $booking->id . '.pdf');
    }
}