<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Payment;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. ✅ CALCULATE $currentBooking (Priority Logic)
        // This ensures we show the Active/Approved booking first, not just the latest one (which might be cancelled).
        
        // Priority A: Check for Approved, Occupied, or Paid (Active stays)
        $currentBooking = $user->bookings()
            ->whereIn('status', ['Approved', 'Occupied', 'Paid'])
            ->with('room')
            ->latest()
            ->first();

        // Priority B: If no active stay, check for a Pending request
        if (!$currentBooking) {
            $currentBooking = $user->bookings()
                ->where('status', 'Pending')
                ->with('room')
                ->latest()
                ->first();
        }

        // Priority C: If nothing else, just get the very last record (e.g., Cancelled/Rejected) to show history
        if (!$currentBooking) {
            $currentBooking = $user->bookings()->with('room')->latest()->first();
        }

        // 2. Extract Room (Helper variable if your view uses $room directly)
        $room = $currentBooking ? $currentBooking->room : null;

        // 3. Fetch Payments
        // Using the relationship if defined, or fallback to manual query
        $payments = Payment::where('user_id', $user->id)->latest()->get();

        // 4. Fetch Announcements
        $announcements = Announcement::latest()->take(5)->get();

        // 5. Return View with 'currentBooking'
        return view('student.dash', compact('currentBooking', 'room', 'payments', 'announcements'));
    }
}