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
        return view('student.profile', compact('user'));
    }

    // ✅ Update user info
        public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }

        // ✅ Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'nullable|string|max:50',
            'program' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
        ]);

        // ✅ Update user
        /** @var \App\Models\User $user */
        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

}
