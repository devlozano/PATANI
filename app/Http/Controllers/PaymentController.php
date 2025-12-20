<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class PaymentController extends Controller
{
    public function index()
    {
        // Fetch payments with relations for the view
        $payments = Payment::with('room', 'user')
            ->where('user_id', Auth::id())
            ->latest() 
            ->get();

        $rooms = Room::where('status', 'available')->get(); 
        
        return view('student.payment', compact('payments', 'rooms'));
    }

    public function store(Request $request)
    {
        $student = auth()->user();

        // 1. Define base rules
        $rules = [
            'room_id' => 'required|exists:rooms,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ];

        // 2. CONDITIONAL VALIDATION: Only require image for GCash/Bank
        if (in_array($request->payment_method, ['gcash', 'bank_transfer'])) {
            $rules['proof_image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
        } else {
            $rules['proof_image'] = 'nullable'; // Optional for Cash/Credit
        }

        $validated = $request->validate($rules);

        // ... (Rest of your existing booking check logic) ...

        // 3. Handle File Upload
        $imagePath = null;
        if ($request->hasFile('proof_image')) {
            $imagePath = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        // 4. Save payment
        $payment = Payment::create([
            'user_id' => $student->id,
            'room_id' => $validated['room_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'Pending', 
            'payment_date' => now(),
            'notes' => 'Payment submitted via portal',
            'reference_no' => strtoupper(uniqid('REF-')),
            'proof_image' => $imagePath, // This will be the path or null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment submitted successfully!',
            'payment' => $payment
        ]);
    }
    // GENERATE RECEIPT PDF
    public function generateReceipt($id)
    {
        $payment = Payment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($payment->status !== 'Approved') {
            return redirect()->back()->with('error', 'Receipt is available only for approved payments.');
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('payment'));
        
        return $pdf->download('Receipt_ref_' . ($payment->reference_no ?? $payment->id) . '.pdf');
    }
}