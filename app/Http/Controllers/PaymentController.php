<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

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

        // 1. Validate fields
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        // 2. Find the CURRENT Active Booking (The latest approved one)
        $currentBooking = Booking::where('room_id', $validated['room_id'])
            ->where('user_id', $student->id)
            ->where('status', 'Approved') 
            ->latest() // Important: Get the most recent approval
            ->first();

        if (!$currentBooking) {
            return response()->json([
                'success' => false,
                'message' => 'No approved booking found for this room.'
            ], 404);
        }

        // 3. Prevent duplicate payments ONLY for THIS SPECIFIC BOOKING instance
        // We check if a payment exists that is NEWER than the booking.
        $existingPayment = Payment::where('user_id', $student->id)
            ->where('room_id', $validated['room_id'])
            ->whereIn('status', ['Pending', 'Approved']) 
            ->where('created_at', '>=', $currentBooking->created_at) // ✅ FIX: Check Date
            ->first();

        if ($existingPayment) {
            $msg = $existingPayment->status == 'Approved' ? 'already paid' : 'pending approval';
            return response()->json([
                'success' => false,
                'message' => "You have $msg for this current booking."
            ], 409);
        }

        // 4. Save payment
        $payment = Payment::create([
            'user_id' => $student->id,
            'room_id' => $validated['room_id'],
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