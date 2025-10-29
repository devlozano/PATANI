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


// 🏠 Redirect homepage to login page
Route::get('/', function () {
    return redirect()->route('login');
});


// 🔐 AUTH ROUTES
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


// 🧭 DASHBOARD
Route::get('/dash', [LoginController::class, 'dash'])->name('dash');


// 👤 PROFILE ROUTES
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


// 💳 PAYMENT ROUTES (student-side)
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');


// 🚪 LOGOUT
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::prefix('student')->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dash');
    })->name('student.dashboard');

    Route::get('/booking', [StudentBookingController::class, 'index'])->name('student.booking');
    Route::post('/booking', [StudentBookingController::class, 'store'])->name('student.booking.store');

    Route::get('/payment', [PaymentController::class, 'index'])->name('student.payment');

    // Student Payment Routes
Route::prefix('student')->middleware(['auth', 'student'])->group(function () {
    Route::get('/payment', [PaymentController::class, 'index'])->name('student.payment');
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
});


    Route::get('/room', [BookingController::class, 'index'])->name('student.room');
});


/// 🧑‍💼 ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Booking
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking');

    // Payments page (index)
    Route::get('/payment', [AdminPaymentController::class, 'index'])->name('payment');

    // Approve a payment
    Route::post('/payment/{id}/approve', [AdminPaymentController::class, 'approve'])->name('payment.approve');

    // Reject a payment
    Route::post('/payment/{id}/reject', [AdminPaymentController::class, 'reject'])->name('payment.reject');

    // Reports page
    Route::get('/report', [AdminReportController::class, 'index'])->name('report');
});
Route::prefix('admin')->name('admin.rooms.')->group(function () {
    Route::get('/rooms', [AdminRoomController::class, 'index'])->name('index'); // Room list
    Route::get('/rooms/create', [AdminRoomController::class, 'create'])->name('create'); // Add room
    Route::post('/rooms', [AdminRoomController::class, 'store'])->name('store'); // Store room
    Route::get('/rooms/{id}/edit', [AdminRoomController::class, 'edit'])->name('edit'); // Edit room
    Route::put('/rooms/{id}', [AdminRoomController::class, 'update'])->name('update'); // Update room
    Route::delete('/rooms/{id}', [AdminRoomController::class, 'destroy'])->name('destroy'); // Delete room
});

// ✅ Approve booking route
Route::post('/booking{id}/approve', [AdminBookingController::class, 'approve'])->name('admin.booking.approve');

// ✅ Reject booking route
Route::post('/booking/{id}/reject', [AdminBookingController::class, 'reject'])->name('admin.booking.reject');

    // Report
    Route::get('/report', [AdminReportController::class, 'index'])->name('report');

    // Rooms CRUD
    Route::resource('rooms', AdminRoomController::class);
