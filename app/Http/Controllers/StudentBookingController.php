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

        // 1. Existing Check: Prevent multiple active bookings for the same user
        $hasActiveBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['Approved', 'Paid', 'Occupied']) // strictly active
            ->exists();

        if ($hasActiveBooking) {
            return redirect()->back()->with('error', 'You already have an active booking.');
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_number' => 'required|string',
        ]);

        // ✅ CRITICAL FIX: Check if this SPECIFIC Bed is already taken
        // We check for any booking that is NOT Cancelled or Rejected
        $isBedTaken = Booking::where('room_id', $request->room_id)
            ->where('bed_number', $request->bed_number)
            ->whereIn('status', ['Pending', 'Approved', 'Paid', 'Occupied']) 
            ->exists();

        if ($isBedTaken) {
            return redirect()->back()->with('error', "Bed {$request->bed_number} is already occupied or pending approval. Please choose another bed.");
        }

        // 2. Gender Restriction Check
        $room = Room::findOrFail($request->room_id);
        $userGender = strtolower($user->gender); 
        $roomGender = strtolower($room->gender);

        if ($roomGender !== 'mixed' && $roomGender !== $userGender) {
            return redirect()->back()->with('error', 'You cannot book this room. It is designated for ' . ucfirst($roomGender) . 's only.');
        }

        // 3. Create Booking
        Booking::create([
            'user_id'    => $user->id,
            'room_id'    => $request->room_id,
            'bed_number' => $request->bed_number,
            'status'     => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Booking request sent successfully!');
    }

   public function cancel($id)
{
    $booking = Booking::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $status = strtolower($booking->status);

    // 1. Check for Payment (Workaround logic)
    // Find an approved payment by this user created AFTER the booking
    $paymentSettled = \App\Models\Payment::where('user_id', Auth::id())
                        ->where('status', 'Approved')
                        ->where('created_at', '>=', $booking->created_at)
                        ->exists();

    // 2. Security Check
    if (($status === 'approved' && $paymentSettled) || $status === 'paid') {
        return redirect()->back()->with('error', 'Cannot cancel a confirmed and paid booking.');
    }

    // 3. Prevent cancelling rejected/cancelled items
    if (!in_array($status, ['pending', 'approved'])) {
         return redirect()->back()->with('error', 'This booking cannot be cancelled.');
    }

    $booking->update(['status' => 'Cancelled']);

    return redirect()->back()->with('success', 'Booking has been cancelled.');
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