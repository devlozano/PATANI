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
            if ($request->status !== 'All') {
                $query->where('status', $request->status);
            }
        }

        // 📅 Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // 🧾 Get filtered payments (History)
        $payments = $query->latest()->get();

        // 🕓 Pending payments only (For the top table)
        $pendingPayments = Payment::with('user', 'room')
            ->where('status', 'Pending')
            ->latest()
            ->get();

        return view('admin.payment', compact('payments', 'pendingPayments'));
    }

    public function approve($id)
    {
        // Find the payment being approved
        $payment = Payment::findOrFail($id);

        // Approve this payment
        $payment->status = 'Approved';
        $payment->save();

        // ✅ LOGIC: If you want to reject other PENDING payments for the SAME MONTH/ROOM automatically:
        // This prevents double payments for the same cycle.
        Payment::where('user_id', $payment->user_id)
            ->where('id', '!=', $payment->id) // Exclude this one
            ->where('status', 'Pending') // Only pending ones
            ->update(['status' => 'Rejected', 'notes' => 'Duplicate payment request automatically rejected.']);

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    /**
     * Reject a payment.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = 'Rejected';
        $payment->notes = $request->reason; // store reason in `notes` column
        $payment->save();

        return redirect()->back()->with('success', 'Payment rejected.');
    }

    // Note: The 'store' method is usually for the Student side, but if Admins can create payments manually:
    public function store(Request $request)
    {
        // Admin creating a payment record manually?
        // Usually not needed if students submit it, but keeping your existing logic structure:
        
        /* If this is intended for Student submission, it should be in PaymentController, not AdminPaymentController.
           If this IS for admin manual entry, remove auth()->user() check or adjust accordingly.
        */

        return redirect()->back(); 
    }
}