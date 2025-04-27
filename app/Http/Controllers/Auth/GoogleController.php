<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallBack(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $findUser = User::where('google_id', $user->id)->first();
        // dd($user);
        if(!is_null($findUser)) {
            Auth::login($findUser);
        } else {
            $findUser = User::create([
                'first_name' => $user->user['given_name'],
                'last_name' => $user->user['family_name'],
                'picture' => $user->user['picture'],
                'birthday' => null,
                'gender' => null,
                'email' => $user->user['email'],
                'phone' => null,
                'google_id' => $user->id,
                'role' => 'travler',
                'status' => 'active',
                'password' => encrypt('123456dummy')
            ]);

            Auth::login($findUser);
        }

        if (Auth::user()->role === 'travler') {
            return redirect()->route('client.home')->with('success', 'You are logged in with Google');
        } elseif (Auth::user()->role === 'guide') {
            return redirect()->route('guide.home')->with('success', 'You are logged in with Google');
        } elseif (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard.index')->with('success', 'You are logged in with Google');
        }

        $user = Auth::user();
            $role = $user->role;
            $currentRoute = $request->route()->getName();

        $redirectRoutes = [
            'travler' => 'client.home',
            'guide' => 'guide.home',
            'admin' => 'admin.dashboard.index',
        ];

        if (isset($redirectRoutes[$role])) {
            if ($user->status === 'inactive') {
                return redirect()->route('warning');
            }

            if ($currentRoute !== $redirectRoutes[$role]) {
                return redirect()->route($redirectRoutes[$role]);
            }
        }
    }
}
