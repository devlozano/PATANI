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
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'amount' => 'required|numeric',
        'payment_method' => 'required|string',
    ]);

    Payment::create([
        'user_id' => Auth::id(),         // ← Add this line
        'room_id' => $request->room_id,
        'amount' => $request->amount,
        'payment_method' => $request->payment_method,
        'status' => 'Pending',           // Admin approves later
    ]);

    return redirect()->back()->with('success', 'Payment submitted successfully. Waiting for admin approval.');
}
}
