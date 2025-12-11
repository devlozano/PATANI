<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StudentBookingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\LandingController;

// 🏠 LANDING PAGE
Route::get('/', [LandingController::class, 'index'])->name('landing.home');
Route::get('/home', fn() => redirect()->route('landing.home'));

// 🔐 AUTH ROUTES
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

// 🛡️ AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.uploadAvatar');
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.removeAvatar');

    // Chat
    Route::get('/chat/messages/{userId}', [AdminDashboardController::class, 'getMessages'])->name('chat.get');
    Route::post('/chat/send', [AdminDashboardController::class, 'sendMessage'])->name('chat.send');
});

// 🎓 STUDENT ROUTES
Route::prefix('student')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dash');
    Route::get('/booking', [StudentBookingController::class, 'index'])->name('student.booking');
    Route::post('/booking', [StudentBookingController::class, 'store'])->name('student.booking.store');
    Route::get('/payment', [PaymentController::class, 'index'])->name('student.payment');
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/room', [BookingController::class, 'index'])->name('student.room');
});

// 🧑‍💼 ADMIN ROUTES
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Announcements
    Route::post('/announcement/post', [AdminDashboardController::class, 'postAnnouncement'])->name('post.announcement');

    // Booking
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking');
    Route::post('/booking/{id}/approve', [AdminBookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{id}/reject', [AdminBookingController::class, 'reject'])->name('booking.reject');
    Route::post('/bookings/{id}/checkout', [AdminBookingController::class, 'checkout'])->name('booking.checkout');

    // Payment
    Route::get('/payment', [AdminPaymentController::class, 'index'])->name('payment');
    Route::post('/payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('payment.approve');
    Route::post('/payment/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payment.reject');

    // ✅ Room Management
    // This makes all RESTful routes for rooms available:
    // GET /admin/rooms -> index
    // GET /admin/rooms/create -> create
    // POST /admin/rooms -> store
    // GET /admin/rooms/{room}/edit -> edit
    // PUT/PATCH /admin/rooms/{room} -> update
    // DELETE /admin/rooms/{room} -> destroy
    Route::resource('rooms', AdminRoomController::class);

    // Reports
    Route::get('/report', [AdminReportController::class, 'index'])->name('report');
});
