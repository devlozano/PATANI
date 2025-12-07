<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Check the 'is_admin' column (1 = Admin, 0 = Student)
        if (Auth::user()->is_admin != 1) {
            // Redirect students back to their dashboard
            return redirect()->route('dash')->with('error', 'Access denied. Admins only.');
        }

        return $next($request);
    }
}