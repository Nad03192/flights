<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightApiController extends Controller
{
    // List all flights
    public function index()
    {
        $flights = Flight::all();
        return response()->json($flights);
    }

    // Create a new flight
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255',
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'available_seats' => 'required|integer|min:0',
        ]);

        $flight = Flight::create($validated);

        return response()->json($flight, 201);
    }

    // Show a specific flight
    public function show(string $id)
    {
        $flight = Flight::findOrFail($id);
        return response()->json($flight);
    }

    // Update an existing flight
    public function update(Request $request, string $id)
    {
        $flight = Flight::findOrFail($id);

        $validated = $request->validate([
            'number' => 'sometimes|string|max:255',
            'departure_city' => 'sometimes|string|max:255',
            'arrival_city' => 'sometimes|string|max:255',
            'departure_time' => 'sometimes|date',
            'arrival_time' => 'sometimes|date',
            'available_seats' => 'sometimes|integer|min:0',
        ]);

        $flight->update($validated);

        return response()->json($flight);
    }

    // Soft delete a flight
    public function destroy(string $id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();

        return response()->json(['message' => 'Flight deleted successfully.']);
    }
}
