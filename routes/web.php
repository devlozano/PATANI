<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// PAYMENT routes
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');

// LOGOUT route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
