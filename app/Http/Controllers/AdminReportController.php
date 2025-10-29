<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;

class AdminReportController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        $payments = Payment::all();

        return view('admin.report', compact('bookings', 'payments'));
    }
}
