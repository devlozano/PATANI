<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // <- Add this line
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
        'booking_id' => 'required|exists:bookings,id',
        'amount' => 'required|numeric|min:0',
        'payment_method' => 'required|string',
    ]);

    // Find the student's approved booking
    $booking = Booking::where('id', $validated['booking_id'])
        ->where('user_id', $student->id)
        ->where('status', 'Approved') // match DB value
        ->first();

    if (!$booking) {
        return response()->json([
            'success' => false,
            'message' => 'No approved booking found for this room.'
        ], 404);
    }

    // Prevent duplicate payments
    $existingPayment = Payment::where('booking_id', $booking->id)
        ->where('status', 'Approved')
        ->first();

    if ($existingPayment) {
        return response()->json([
            'success' => false,
            'message' => 'You already paid for this booking.'
        ], 409);
    }

    // Save payment
    $payment = Payment::create([
        'user_id' => $student->id,
        'room_id' => $validated['room_id'],
        'booking_id' => $booking->id,
        'amount' => $validated['amount'],
        'payment_method' => $validated['payment_method'],
        'status' => 'Pending', // Admin will approve
        'payment_date' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Payment submitted and pending approval.',
        'payment' => $payment
    ]);
}


}
