<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    // Show the registration page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration form submission
    public function register(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'program' => 'required|string|max:100',
            'gender' => 'required|string|max:10',
            'contact' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        // ✅ Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'program' => $validated['program'],
            'gender' => $validated['gender'],
            'contact' => $validated['contact'],
            'address' => $validated['address'],
        ]);

        // ✅ Redirect to dashboard or home
        return redirect()->route('login')->with('success', 'Account created successfully!');
    }
}