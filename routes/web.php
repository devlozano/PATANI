<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth', function () {
    // Ensure resources/views/auth/auth.blade.php exists
    return view('auth.auth');
});

Route::get('/login', function () {
    // Ensure resources/views/login.blade.php exists
    return view('auth.login');
});