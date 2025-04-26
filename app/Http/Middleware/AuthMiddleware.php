<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check()) {
            $role = Auth::user()->role;
            $currentRoute = $request->route()->getName();

            if ($role == 'travler' && $currentRoute !== 'client.home') {
                return redirect()->route('client.home');
            } elseif ($role == 'guide' && $currentRoute !== 'guide.dashboard') {
                return redirect()->route('guide.dashboard');
            } elseif ($role == 'admin' && $currentRoute !== 'admin.dashboard.index') {
                return redirect()->route('admin.dashboard.index');
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        return $response;
    }
}
