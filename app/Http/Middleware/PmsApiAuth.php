<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PmsApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isLoggedIn = session()->has('access_token') && session()->has('user_id');

        // ✅ If logged in and trying to access login page, redirect to dashboard
        if ($isLoggedIn && $request->is('login')) {
            return redirect()->route('dashboard');
        }

        // ❌ If not logged in and trying to access protected pages (not login), redirect to login
        if (!$isLoggedIn && !$request->is('login')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Please log in first.'
            ]);
        }
        return $next($request);
    }
}
