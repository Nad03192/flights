<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use App\Exports\FlightsExport;
use Maatwebsite\Excel\Facades\Excel;
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
public function export()
{
    $flights = Flight::all();

    $filename = "flights_export_" . date('Y-m-d_H-i-s') . ".csv";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = ['Number', 'Departure City', 'Arrival City', 'Departure Time', 'Arrival Time', 'Available Seats'];

    $callback = function() use ($flights, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($flights as $flight) {
            fputcsv($file, [
                $flight->number,
                $flight->departure_city,
                $flight->arrival_city,
                $flight->departure_time,
                $flight->arrival_time,
                $flight->available_seats
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}
