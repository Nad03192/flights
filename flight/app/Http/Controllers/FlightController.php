<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $flights = Flight::when($search, function ($query, $search) {
                return $query->where('number', 'like', "%{$search}%")
                             ->orWhere('departure_city', 'like', "%{$search}%")
                             ->orWhere('arrival_city', 'like', "%{$search}%");
            })
            ->withTrashed()
            ->get();

        return view('flights.index', compact('flights', 'search'));
    }

    public function create()
    {
        return view('flights.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string',
            'departure_city' => 'required|string',
            'arrival_city' => 'required|string',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        Flight::create($request->all());

        return redirect()->route('flights.index')->with('success', 'Flight created successfully.');
    }

    public function edit(Flight $flight)
    {
        return view('flights.edit', compact('flight'));
    }

    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'number' => 'required|string',
            'departure_city' => 'required|string',
            'arrival_city' => 'required|string',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        $flight->update($request->all());

        return redirect()->route('flights.index')->with('success', 'Flight updated successfully.');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('flights.index')->with('success', 'Flight soft deleted.');
    }

    public function restore($id)
    {
        $flight = Flight::withTrashed()->findOrFail($id);
        $flight->restore();
        return redirect()->route('flights.index')->with('success', 'Flight restored.');
    }

    public function showPassengers(Flight $flight)
    {
        $passengers = $flight->passengers;
        return view('passengers.index', compact('passengers'));
    }
}
