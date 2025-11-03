<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Room;

class AdminPaymentController extends Controller
{
    /**
     * Display all payments and pending payments with optional filters.
     */
    public function index(Request $request)
    {
        $query = Payment::with('user', 'room');

        // 🔍 Filter by student name
        if ($request->filled('student')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student . '%');
            });
        }

        // 📊 Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 📅 Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        // 🧾 Get filtered payments
        $payments = $query->latest()->get();

        // 🕓 Pending payments only
        $pendingPayments = Payment::with('user', 'room')
            ->where('status', 'Pending')
            ->latest()
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

        // ✅ Optionally mark the room as occupied
        if ($payment->room) {
            $payment->room->update(['status' => 'occupied']);
        }

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    /**
     * Reject a payment.
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $payment->status = 'Rejected';
        $payment->notes = $request->reason; // store reason in `notes` column
        $payment->save();

        return redirect()->back()->with('success', 'Payment rejected with reason.');
    }
}
