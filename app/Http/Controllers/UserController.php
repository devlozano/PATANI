<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dash()
    {
        return view('dash'); // 👈 Make sure you have resources/views/dash.blade.php
    }
}
