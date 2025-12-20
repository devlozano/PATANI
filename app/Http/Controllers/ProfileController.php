<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access your profile.');
        }
        return view('student.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // ✅ CASE 1: PASSWORD UPDATE
        if ($request->input('update_type') === 'password') {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|confirmed|min:8',
            ]);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->back()->with('success', 'Password changed successfully!');
        }

        // ✅ CASE 2: PROFILE INFO UPDATE
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:5', // Max 5 just in case
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
        ]);

        // 1. Prepare Names
        $firstName = $validated['first_name'];
        $lastName = $validated['last_name'];
        
        // ✅ FIX: Remove any period (.) the user might have typed
        $middleInitial = isset($validated['middle_initial']) 
            ? str_replace('.', '', $validated['middle_initial']) 
            : '';

        // 2. Construct Full Name
        $fullName = $firstName;
        if (!empty($middleInitial)) {
            $fullName .= ' ' . $middleInitial; // No period added here
        }
        $fullName .= ' ' . $lastName;

        // 3. Assign values
        $user->name = $fullName;
        
        $user->first_name = $firstName;
        $user->middle_initial = $middleInitial; // Saves cleanly without period
        $user->last_name = $lastName;
        
        $user->email = $validated['email'];
        $user->gender = $validated['gender'];
        $user->address = $validated['address'];
        $user->contact = $validated['contact'];

        $user->save();

        return redirect()->back()->with('success', 'Profile information updated successfully!');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|max:2048']);
        $user = Auth::user();

        if ($user->avatar && file_exists(storage_path('app/public/avatars/' . $user->avatar))) {
            unlink(storage_path('app/public/avatars/' . $user->avatar));
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = basename($path);
        $user->save();

        return back()->with('success', 'Avatar updated successfully!');
    }

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