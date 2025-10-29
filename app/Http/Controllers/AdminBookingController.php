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
        $booking = Booking::findOrFail($id);
        $booking->status = 'Approved';
        $booking->save();

        return redirect()->back()->with('success', 'Booking approved successfully!');
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
        $booking->status = 'Checked_out';
        $booking->save();

        return redirect()->back()->with('success', 'Guest checked out successfully.');
    }
}
