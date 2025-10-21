<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth', function () {
    return view('auth.auth');
});

Route::get('login', function () {
    return view('login');
});