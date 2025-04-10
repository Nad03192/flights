<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Passenger;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $passengerId = session('passenger_id');
        
        if ($passengerId) {
            $passenger = Passenger::find($passengerId);

            if ($passenger && $passenger->roles()->where('name', 'admin')->exists()) {
                return $next($request); 
            }
        }

        return redirect()->route('login.form')->withErrors(['error' => 'You do not have access to this page.']);
    }
}
