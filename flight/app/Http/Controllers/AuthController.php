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
            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => 'required|email|unique:passengers,email',
            'password'          => 'required|confirmed|min:6',
            'dob'               => 'required|date',  
            'passport_expiry_date' => 'required|date', 
        ]);
    
        $passenger = Passenger::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'dob'               => $request->dob,  
            'passport_expiry_date' => $request->passport_expiry_date, 
        ]);
    
        session(['passenger_id' => $passenger->id]);
        return redirect()->route('flights.list'); 
    }
    

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
    
        $passenger = Passenger::where('email', $request->email)->first();
    
        if ($passenger && Hash::check($request->password, $passenger->password)) {
          
            $isAdmin = $passenger->roles()->where('name', 'admin')->exists();
    
            if ($isAdmin) {
                session(['passenger_id' => $passenger->id]);
                return redirect()->route('flights.index'); 
            }
    
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
    public function listFlights(Request $request)
    {
        $query = Flight::withCount('passengers');
    
        if ($request->has('search') && !empty($request->search)) {
            $query->where('number', 'like', '%' . $request->search . '%')
                  ->orWhere('departure_city', 'like', '%' . $request->search . '%')
                  ->orWhere('arrival_city', 'like', '%' . $request->search . '%');
        }
    
        $flights = $query->get();
    
        return view('flights.list', compact('flights'));
    }


public function bookFlight($flightId)
{
    $passengerId = session('passenger_id'); 

    $flight = Flight::withCount('passengers')->findOrFail($flightId);

    $alreadyBooked = $flight->passengers()->where('passenger_id', $passengerId)->exists();

    if ($alreadyBooked) {
        return back()->withErrors(['error' => 'You have already booked this flight.']);
    }

    if ($flight->passengers_count >= $flight->available_seats) {
        return back()->withErrors(['error' => 'Flight is fully booked']);
    }

    $flight->passengers()->attach($passengerId);

    return back()->with('success', 'Flight booked successfully!');
}

public function showFlightsForPassenger()
{
    $passengerId = session('passenger_id'); 

    $passenger = Passenger::with('flights')->findOrFail($passengerId);

 
    $flights = $passenger->flights;

    return view('flights.passenger_flights', compact('flights', 'passenger'));
}

public function showLoginForm()
{
    if (session('passenger_id')) {
        return redirect()->route('flights.list'); 
    }
    return view('auth.login');
}

}


