<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Auth; // ✅ Remove or comment this out if not used elsewhere

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validate inputs
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|string',
            'contact' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Create Full Name
        $middle = $request->middle_initial ? $request->middle_initial . ' ' : '';
        $fullName = $request->first_name . ' ' . $middle . $request->last_name;

        // 3. Create User
        User::create([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'middle_initial' => $request->middle_initial,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'contact' => $request->contact,
            'address' => $request->address,
            'role' => 'student',
        ]);

        // 4. ✅ FIX: Do NOT auto-login. Redirect directly to login page.
        // Auth::login($user); <--- Removed this line

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}