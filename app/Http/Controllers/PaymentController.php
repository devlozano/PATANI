<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('room', 'user')->where('user_id', Auth::id())->get();
        $rooms = Room::where('status', 'available')->get(); 
        return view('student.payment', compact('payments', 'rooms'));
    }

    public function store(Request $request)
    {
        $student = auth()->user();

        // 1. Validate fields (Removed booking_id from DB check)
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            // 'booking_id' is optional in validation since we don't save it to payments table
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        // 2. Verify the student actually has an approved booking for this room
        // This ensures they can't pay for a room they haven't booked, even without booking_id in payments table
        $hasApprovedBooking = Booking::where('room_id', $validated['room_id'])
            ->where('user_id', $student->id)
            ->where('status', 'Approved') 
            ->exists();

        if (!$hasApprovedBooking) {
            return response()->json([
                'success' => false,
                'message' => 'No approved booking found for this room.'
            ], 404);
        }

        // 3. Prevent duplicate PENDING payments for the same room
        // (We check User + Room + Status=Pending)
        $existingPendingPayment = Payment::where('user_id', $student->id)
            ->where('room_id', $validated['room_id'])
            ->where('status', 'Pending')
            ->first();

        if ($existingPendingPayment) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending payment for this room.'
            ], 409);
        }

        // 4. Save payment (WITHOUT booking_id)
        $payment = Payment::create([
            'user_id' => $student->id,
            'room_id' => $validated['room_id'],
            // 'booking_id' => $booking->id,  <-- REMOVED THIS LINE
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'Pending', 
            'payment_date' => now(),
            'notes' => 'Payment submitted via portal'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment submitted and pending approval.',
            'payment' => $payment
        ]);
    }
}