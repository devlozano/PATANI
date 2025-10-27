<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Show the payment page
    public function index()
    {
        $payments = Payment::with('room', 'user')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payment', compact('payments'));
    }

    // Store a new payment
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'room_id' => 'required|exists:rooms,id',
        ]);

        Payment::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'amount' => $request->amount,
            'payment_date' => now(),
            'status' => 'Pending',
        ]);

        return redirect()->route('payment')->with('success', 'Payment recorded successfully!');
    }
}
