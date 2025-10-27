<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Room; 
use App\Models\User;

class LoginController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('auth.login'); // make sure this exists
    }

    // Show register page
    public function showRegister()
    {
        return view('auth.register'); // this is your signup page
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'program' => 'required|string|max:100',
            'gender' => 'required|string',
            'contact' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'program' => $request->program,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('dash');
    }

        public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ Redirect based on role
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dash');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Dashboard method (this fixes your error)
    public function dash()
    {
        return view('dash'); // make sure resources/views/dash.blade.php exists
    }

    public function booking()
    {
        $rooms = Room::all();
        return view('booking', compact('rooms'));
    }

    // Payment method
    public function payment()
    {
        return view('payment'); // make sure resources/views/payment.blade.php exists
    }

} 