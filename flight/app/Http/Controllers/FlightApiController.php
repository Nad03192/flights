<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightApiController extends Controller
{
    
   public function index(Request $request)
{
    $search = $request->get('search');
    $sortBy = $request->get('sort_by', 'number'); 
    $sortOrder = $request->get('sort_order', 'asc'); 
    $perPage = $request->get('per_page', 10); 

    $flights = Flight::withCount('passengers')
        ->when($search, function ($query) use ($search) {
            $query->where('number', 'like', "%$search%")
                  ->orWhere('departure_city', 'like', "%$search%")
                  ->orWhere('arrival_city', 'like', "%$search%");
        })
        ->orderBy($sortBy, $sortOrder)
        ->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $flights
    ]);
}

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

    public function show(Flight $flight)
{
    if ($flight) {
        return response()->json($flight);
    } else {
        return response()->json(['message' => 'Flight not found'], 404);
    }
}



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

   
    public function destroy(string $id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();

        return response()->json(['message' => 'Flight deleted successfully.']);
    }
}
