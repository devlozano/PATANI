<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Fetch latest booking (with room)
        $booking = $student->bookings()->with('room')->latest()->first();
        $room = $booking ? $booking->room : null;

        // Fetch payments made by this student
        $payments = $student->payments()->latest()->get();

        return view('student.dash', compact('room', 'payments'));
    }
}