<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    public function index()
    {
        $pending = Booking::where('status', 'pending')->get();
        $all = Booking::all();

        return view('admin.booking', compact('pending', 'all'));
    }

    public function approve($id)
{
    // Find the booking being approved
    $booking = Booking::findOrFail($id);

    // Approve this booking
    $booking->status = 'Approved';
    $booking->save();

    // Automatically cancel other bookings for the same student
    Booking::where('user_id', $booking->user_id)
        ->where('id', '!=', $booking->id)  // Exclude the approved booking
        ->whereIn('status', ['Pending', 'Approved']) // Cancel only pending or mistakenly approved ones
        ->update(['status' => 'Cancelled']);

    return redirect()->back()->with('success', 'Booking approved. Other bookings for this student have been cancelled.');
}


    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'Cancelled';
        $booking->save();

        return redirect()->back()->with('error', 'Booking rejected.');
    }

public function checkout($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'CheckedOut';
    $booking->save();

    return redirect()->back()->with('success', 'Student has been checked out successfully.');
}

}
