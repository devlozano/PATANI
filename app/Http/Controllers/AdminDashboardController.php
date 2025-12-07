<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Announcement;
use App\Models\Message;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats
        // Count users where is_admin is 0 (Students)
        $totalStudents = User::where('is_admin', 0)->count(); 
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
    }

    // --- ANNOUNCEMENTS ---
    public function postAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        Announcement::create([
            'title' => $request->title,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'Announcement posted successfully!');
    }

    // --- CHAT LOGIC ---
    public function getMessages($userId)
    {
        $myId = Auth::id();

        $messages = Message::where(function($q) use ($myId, $userId) {
            $q->where('sender_id', $myId)->where('receiver_id', $userId);
        })->orWhere(function($q) use ($myId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $myId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json(['status' => 'success', 'message' => $message]);
    }
}