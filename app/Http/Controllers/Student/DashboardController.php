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
    $bookings = $student->bookings()->with('room')->latest()->first();
    $room = $bookings ? $bookings->room : null;

    // Fetch payments for this student
    $payments = $student->payments()->latest()->get();

    return view('student.dash', compact('bookings', 'room', 'payments'));
}
}