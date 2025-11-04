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

public function approve($id)
{
    // Find the payment being approved
    $payment = Payment::findOrFail($id);

    // Approve this payment
    $payment->status = 'Approved';
    $payment->save();

    // Automatically cancel or delete other payments for the same student
    Payment::where('user_id', $payment->user_id)
        ->where('id', '!=', $payment->id) // Exclude the approved payment
        ->whereIn('status', ['Pending', 'Submitted']) // Only remove pending/submitted
        ->update(['status' => 'Cancelled']); // Or delete() if you prefer: ->delete()

    return redirect()->back()->with('success', 'Payment approved. Other payments have been cancelled.');
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

    public function store(Request $request)
{
    $user = auth()->user();

    // Prevent multiple active payments
    $hasApprovedPayment = Payment::where('user_id', $user->id)
        ->where('status', 'Approved')
        ->exists();

    if ($hasApprovedPayment) {
        return redirect()->back()->with('error', 'You already have an approved payment. You cannot pay another until your current payment is processed.');
    }

    Payment::create([
        'user_id' => $user->id,
        'room_id' => $request->room_id,
        'amount' => $request->amount,
        'status' => 'Pending',
    ]);

    return redirect()->back()->with('success', 'Payment submitted successfully.');
}

}
