<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class GuideMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has guide role
        if (Auth::check() && Auth::user()->role === 'guide') {
            return $next($request);
        }

        // Redirect to home with error message
        return redirect()->route('index')->with('error', 'Access denied. You need guide privileges to access this area.');
    }
}
