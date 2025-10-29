<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Room;

class AdminPaymentController extends Controller
{
    /**
     * Display all payments and pending payments.
     */
    public function index()
    {
        // All payments with related user and room
        $payments = Payment::with('user', 'room')->get();

        // Only pending payments (query directly for efficiency)
        $pendingPayments = Payment::with('user', 'room')
            ->where('status', 'Pending')
            ->get();

        return view('admin.payment', compact('payments', 'pendingPayments'));
    }

    /**
     * Approve a payment.
     */
    public function approve($id)
    {
        $payment = Payment::with('room')->findOrFail($id);
        $payment->update(['status' => 'Approved']);

        // Optional: mark the room as occupied
        if ($payment->room) {
            $payment->room->update(['status' => 'occupied']);
        }

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    /**
     * Reject a payment.
     */
    public function reject($id)
    {
        $payment = Payment::with('room')->findOrFail($id);
        $payment->update(['status' => 'Rejected']);

        // Optional: if needed, mark the room as available
        if ($payment->room) {
            $payment->room->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', 'Payment rejected successfully.');
    }
}
