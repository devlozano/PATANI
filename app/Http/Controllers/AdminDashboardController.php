<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalStudents = User::count();
        $totalRooms = Room::count();
        $pendingBookings = Booking::where('status', 'Pending')->count();
        $pendingPayments = Payment::where('status', 'Pending')->count();

        // Recent records
        $recentBookings = Booking::with('user', 'room')->latest()->take(5)->get();
        $recentPayments = Payment::with('user', 'room')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalRooms',
            'pendingBookings',
            'pendingPayments',
            'recentBookings',
            'recentPayments'
        ));
        return view('admin.rooms-edit', compact('room'))->with('title', 'Edit Room #' . $room->id);

    }    

}
