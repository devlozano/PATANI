<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class AdminBookingController extends Controller
{
    public function index()
    {
        // Get bookings sorted by newest first
        $pending = Booking::where('status', 'pending')->latest()->get();
        $all = Booking::latest()->get();

        return view('admin.booking', compact('pending', 'all'));
    }

    public function approve($id)
    {
        // Find the booking being approved
        $booking = Booking::findOrFail($id);

        // Approve this booking
        $booking->status = 'Approved';
        $booking->due_date = now()->addMonth(); // Set due date to next month
        $booking->save();
        
        // ✅ LOGIC: Automatically cancel other PENDING bookings for the same student
        // We do not want to cancel "CheckedOut" or "Paid" history, just conflicting requests.
        Booking::where('user_id', $booking->user_id)
            ->where('id', '!=', $booking->id)  // Exclude the one we just approved
            ->whereIn('status', ['Pending', 'pending']) // Only cancel pending requests
            ->update(['status' => 'Cancelled']);

        return redirect()->back()->with('success', 'Booking approved successfully.');
    }

    // ✅ UPDATED: Reject with Reason
    public function reject(Request $request, $id)
    {
        // 1. Validate that a reason was provided
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $booking = Booking::findOrFail($id);
        
        // 2. Update status to 'Rejected' and save the reason
        $booking->status = 'Rejected';
        $booking->rejection_reason = $request->rejection_reason; // Save the message
        $booking->save();

        // ✅ USES 'error' KEY: This triggers the RED message in your HTML
        return redirect()->back()->with('error', 'Booking has been rejected.');
    }

    public function checkout($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Update status to CheckedOut
        $booking->status = 'CheckedOut';
        $booking->save();

        return redirect()->back()->with('success', 'Student has been checked out successfully.');
    }
}