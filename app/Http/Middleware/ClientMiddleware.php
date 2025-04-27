<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'travler') {
            return $next($request);
        }

        return redirect()->route('index')->with('error', 'Access denied. You need to be logged in as a traveler to access this area.');
    }
}
