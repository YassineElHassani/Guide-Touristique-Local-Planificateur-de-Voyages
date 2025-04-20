<?php

namespace App\Http\Controllers;

// use App\Models\Auth;
use App\Http\Middleware\AuthMiddleware;
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

    public function adminDashboard() {
        return view('admin.dashboard');
    }

    public function guideDashboard() {
        return view('guide.dashboard');
    }

    public function clientDashboard() {
        return view('client.home');
    }

    public function signup(Request $request) {
        $data = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|max:20',
            'role' => 'required|in:travler,guide',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'status' => 'required',
        ];

        $request->validate($data);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        if(!$user) {
            return redirect(route('register'))->with("error", "Registration failed, try again!");
        }

        return redirect(route('login'))->with("success", "You have registered Successfully, Login to access the platform.");
    }

    public function signin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $messageCredentials = $request->only('email', 'password');
        
        
        if(Auth::attempt($messageCredentials)) {
            return redirect()->intended()->with("success", "You have logged in successfully!");
        }

        return redirect(route('login'))->with("error", "Email or Password is invalid!");
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
