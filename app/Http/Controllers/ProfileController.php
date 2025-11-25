<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access your profile.');
        }

        return view('student.profile', compact('user'));
    }

    /**
     * Update user profile information (without forcing avatar upload).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }

        // ✅ Validate all fields (avatar optional here)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ Handle avatar upload (optional)
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/avatars/' . $user->avatar))) {
                unlink(storage_path('app/public/avatars/' . $user->avatar));
            }

            $fileName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/avatars', $fileName);
            $validated['avatar'] = $fileName;
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload or change avatar only.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar && file_exists(storage_path('app/public/avatars/' . $user->avatar))) {
            unlink(storage_path('app/public/avatars/' . $user->avatar));
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = basename($path);
        $user->save();

        return back()->with('success', 'Avatar updated successfully!');
    }

    /**
     * Remove avatar and revert to default initials.
     */
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && file_exists(storage_path('app/public/avatars/' . $user->avatar))) {
            unlink(storage_path('app/public/avatars/' . $user->avatar));
        }

        $user->avatar = null;
        $user->save();

        return back()->with('success', 'Avatar removed.');
    }
}
