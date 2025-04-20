<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilesController extends Controller
{
    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your profile.');
        }
        
        $user = Auth::user();
        $profile = User::where('id', $user->id)->first();
        
        // Create a profile if none exists
        if (!$profile) {
            $profile = User::create(['id' => $user->id]);
        }
        
        return view('profile.show', compact('user', 'profile'));
    }

    public function edit()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to edit your profile.');
        }
        
        $user = Auth::user();
        $profile = User::where('id', $user->id)->first();
        
        // Create a profile if none exists
        if (!$profile) {
            $profile = User::create(['id' => $user->id]);
        }
        
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update your profile.');
        }
        
        $user = Auth::user();
        $profile = User::where('id', $user->id)->first();
        
        // Create a profile if none exists
        if (!$profile) {
            $profile = User::create(['id' => $user->id]);
        }
        
        // Validate user data
        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female',
            'birthday' => 'date',
            'phone' => 'string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Handle picture upload
        if ($request->hasFile('picture')) {
            // Delete old picture if it exists
            if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                Storage::disk('public')->delete($user->picture);
            }

            // Store new picture
            $newPicturePath = $request->file('picture')->store('avatars', 'public');
        } else {
            $newPicturePath = $user->picture;
        }

        // Check current password if changing password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }
        }
        
        // Update user information
        User::update([
            'picture' => $newPicturePath,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);
        
        // Update password if provided
        if ($request->filled('password')) {
            User::update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}