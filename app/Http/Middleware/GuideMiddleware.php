<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class GuideMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'guide') {
            return $next($request);
        }

        return redirect()->route('index')->with('error', 'Access denied. You need guide privileges to access this area.');
    }
}
