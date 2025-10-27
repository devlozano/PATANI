<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin_dashboard'); // 👈 Make sure this file exists
    }

        public function booking()
    {
        return view('admin.admin_booking'); // make sure the view file exists
    }

    public function payment()
    {
        return view('admin.admin_payment'); // make sure the view file exists
    }

        public function room()
    {
        return view('admin.admin_room'); // make sure the view file exists
    }
    public function report()
    {
        return view('admin.admin_report'); // make sure the view file exists
    }
}
