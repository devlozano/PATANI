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
            // UPDATED: Validation for separate name fields
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\-]+$/'],
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\-]+$/'],
            'middle_initial' => ['nullable', 'string', 'max:5'], // Optional
            
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' checks password_confirmation field automatically
            'gender' => 'required|string|in:Male,Female,Other',
            'contact' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\+\s]+$/'],
            'address' => 'required|string|max:255',
        ]);

        // ✅ Create user
        $user = User::create([
            // UPDATED: Save separate fields
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_initial' => $validated['middle_initial'] ?? null, 
            
            // We removed 'name' because your User model now combines these 3 fields automatically
            
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'contact' => $validated['contact'],
            'address' => $validated['address'],
            'role' => 'student', // Default role
        ]);

        // ✅ Redirect to login with success message
        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }
}