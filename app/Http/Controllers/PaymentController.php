<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('room', 'user')->where('user_id', Auth::id())->get();
        $rooms = Room::where('status', 'available')->get(); // Optional if you want selectable rooms
        return view('student.payment', compact('payments', 'rooms'));
    }

public function store(Request $request)
{
    $student = auth()->user();

    // Validate required fields
    $validated = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'amount' => 'required|numeric|min:0',
        'booking_id' => 'nullable|exists:bookings,id',
        'payment_method' => 'required|string',
    ]);

    // 🔍 Find the student's approved booking for this room
    $booking = Booking::where('id', $validated['booking_id'])
        ->where('user_id', $student->id)
        ->where('status', 'approved')
        ->first();

    if (!$booking) {
        return back()->with('error', 'No approved booking found for this room.');
    }

    // ✅ Prevent duplicate payments for the same booking
    $existingPayment = Payment::where('booking_id', $booking->id)
        ->where('status', 'Approved')
        ->first();

    if ($existingPayment) {
        return back()->with('error', 'You already paid for this booking.');
    }

    // ✅ Save payment correctly with booking_id and user_id
    Payment::create([
        'user_id' => $student->id,
        'room_id' => $validated['room_id'],
        'booking_id' => $booking->id,
        'amount' => $validated['amount'],
        'payment_method' => $validated['payment_method'],
        'status' => 'Pending', // Admin will approve
        'payment_date' => now(),
    ]);

    return back()->with('success', 'Payment submitted and pending approval.');
}

}
