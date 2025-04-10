<?php

 namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Passenger;
use App\Models\Flight;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:passengers,email',
            'password'   => 'required|confirmed|min:6',
        ]);

        $passenger = Passenger::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        session(['passenger_id' => $passenger->id]);
        return redirect()->route('flights.list');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $passenger = Passenger::where('email', $request->email)->first();

        if ($passenger && Hash::check($request->password, $passenger->password)) {
            session(['passenger_id' => $passenger->id]);
            return redirect()->route('flights.list');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        session()->forget('passenger_id');
        return redirect()->route('login.form');
    }

    public function listFlights()
    {
        $flights = Flight::withCount('passengers')->get();

        return view('flights.list', compact('flights'));
    }

    public function bookFlight($flightId)
    {
        $passengerId = session('passenger_id');

        $flight = Flight::withCount('passengers')->findOrFail($flightId);

        if ($flight->passengers_count >= $flight->available_seats) {
            return back()->withErrors(['error' => 'Flight is fully booked']);
        }

        $flight->passengers()->attach($passengerId);

        return back()->with('success', 'Flight booked successfully!');
    }
}


