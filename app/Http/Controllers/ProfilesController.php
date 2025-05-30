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
        
        if (!$profile) {
            $profile = User::create(['id' => $user->id]);
        }

        if ($user->role === 'travler') {
            return view('client.profile.show', compact('user', 'profile'));
        } elseif ($user->role === 'guide') {
            return view('guide.profile.show', compact('user', 'profile'));
        } else {
            return view('profile.show', compact('user', 'profile'));
        }
        
    }

    public function edit()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to edit your profile.');
        }
        
        $user = Auth::user();
        $profile = User::where('id', $user->id)->first();
        
        if (!$profile) {
            $profile = User::create(['id' => $user->id]);
        }

        if ($user->role === 'travler') {
            return view('client.profile.edit', compact('user', 'profile'));
        } elseif ($user->role === 'guide') {
            return view('guide.profile.edit', compact('user', 'profile'));
        }
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update your profile.');
        }
        
        $user = Auth::user();
        
        $updateType = $request->input('update_type', 'profile_info');
        
        if ($updateType === 'profile_info') {
            $request->validate([
                'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'nullable|in:male,female,other',
                'birthday' => 'nullable|date',
                'phone' => 'nullable|string|max:20',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            ]);
            
            if ($request->hasFile('picture')) {
                if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                    Storage::disk('public')->delete($user->picture);
                }

                $newPicturePath = $request->file('picture')->store('avatars', 'public');
            } else {
                $newPicturePath = $user->picture;
            }

            $user->update([
                'picture' => $newPicturePath,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            
            $message = 'Profile information updated successfully.';
        } else {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }
            
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            
            $message = 'Password updated successfully.';
        }
        
        if ($user->role === 'travler') {
            return redirect()->route('client.profile.show')->with('success', $message);
        } elseif ($user->role === 'guide') {
            return redirect()->route('guide.profile.show')->with('success', $message);
        }
        
    }
}