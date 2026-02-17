<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidAccessCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('active_access_code') && !$request->session()->has('pending_access_code')) {
            return redirect()->route('access-code.show');
        }

        // If user has a pending code but is not logged in, and tries to access the home page,
        // redirect them to register.
        if ($request->session()->has('pending_access_code') && !auth()->check() && $request->routeIs('home')) {
            return redirect()->route('register');
        }

        return $next($request);
    }
}
