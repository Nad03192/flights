<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If user is not authenticated, redirect to login page
        if (!Auth::check()) {
            return redirect('/login');
        }

        // If user is authenticated but not an admin, redirect to home or another page
        if (!Auth::user()->is_admin) {
            return redirect('/home');  // or any other page you want to redirect to
        }

        // Proceed with the request if the user is an admin
        return $next($request);
    }
}
