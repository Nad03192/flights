<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Flight;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class FlightController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $flights = QueryBuilder::for(Flight::withCount('passengers'))
            ->allowedFilters([
                AllowedFilter::partial('number'),
                AllowedFilter::partial('departure_city'),
                AllowedFilter::partial('arrival_city'),
            ])
            ->allowedSorts(['number', 'departure_city', 'arrival_city', 'departure_time', 'arrival_time', 'available_seats'])
            ->paginate($perPage)
            ->appends($request->query());

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

        return response()->json([
            'success' => true,
            'data' => $flight
        ], 201);
    }

    public function show(Flight $flight)
    {
        return response()->json([
            'success' => true,
            'data' => $flight
        ]);
    }

    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'number' => 'sometimes|string|max:255',
            'departure_city' => 'sometimes|string|max:255',
            'arrival_city' => 'sometimes|string|max:255',
            'departure_time' => 'sometimes|date',
            'arrival_time' => 'sometimes|date',
            'available_seats' => 'sometimes|integer|min:0',
        ]);

        $flight->update($validated);

        return response()->json([
            'success' => true,
            'data' => $flight
        ]);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();

        return response()->json([
            'success' => true,
            'message' => 'Flight deleted successfully.'
        ]);
    }
}
