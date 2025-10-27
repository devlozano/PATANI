<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

// Redirect homepage to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// LOGIN routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// REGISTER routes
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// DASHBOARD route
Route::get('/dash', [LoginController::class, 'dash'])->name('dash');

// BOOKING routes
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// PROFILE routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// PAYMENT routes
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');

// LOGOUT route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


//ADMIN routes can be added here later

// Student dashboard
Route::get('/dash', [UserController::class, 'dash'])->name('dash');

// Admin dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin booking management
Route::get('/admin/booking', [AdminController::class, 'booking'])->name('admin.booking');

// Admin payment management
Route::get('/admin/payment', [AdminController::class, 'payment'])->name('admin.payment');

// Admin room management
Route::get('/admin/room', [AdminController::class, 'room'])->name('admin.room');

// Admin report management
Route::get('/admin/report', [AdminController::class, 'report'])->name('admin.report');