<?php

namespace App\Http\Controllers;

// use App\Models\Auth;
use App\Models\User;
use App\Models\companys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.signup');
    }

    public function signup(Request $request) {
        $data = [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'birthday' => 'required|date',
            'phone' => 'required',
            'role' => 'required|in:travler,guide',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'status' => 'required',
        ];

        $request->validate($data);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        if(!$user) {
            return redirect(route('register'))->with("Error", "Registration failed, try again!");
        }

        return redirect(route('login'))->with("Success", "You have registered Successfully, Login to access the platform.");
    }

    public function signin(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $messageCredentials = $request->only('email', 'password');
        
        if(Auth::attempt($messageCredentials)) {
            return redirect()->intended(route('view'));
        }

        return redirect(route('login'))->with("Error", "Email or Password is invalid!");
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
