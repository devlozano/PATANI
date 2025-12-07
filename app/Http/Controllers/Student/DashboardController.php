<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement; // Import the model

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // 1. Fetch latest booking (with room)
        $bookings = $student->bookings()->with('room')->latest()->first();
        $room = $bookings ? $bookings->room : null;

        // 2. Fetch payments for this student
        $payments = $student->payments()->latest()->get();

        // 3. NEW: Fetch Announcements (Latest first)
        $announcements = Announcement::latest()->get();

        return view('student.dash', compact('bookings', 'room', 'payments', 'announcements'));
    }
}