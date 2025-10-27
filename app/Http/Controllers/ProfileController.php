<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // ✅ Update user info
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:10',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'department' => 'nullable|string|max:100',
            'program' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
        ]);

        // Update user info
        $user->update($validated);

        // Redirect with success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
