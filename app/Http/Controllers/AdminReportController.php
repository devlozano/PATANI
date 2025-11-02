<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;

class AdminReportController extends Controller
{
      public function index()
    {
        // Fetch all payment records, with student relation if exists
        $payments = Payment::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.report', compact('payments'));
    }
}
