<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Passenger;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Cache;

class PassengerController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $cacheKey = 'passengers_' . md5(json_encode($request->all()));

        $passengers = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request, $perPage) {
            return QueryBuilder::for(Passenger::class)
                ->allowedFilters([
                    AllowedFilter::partial('first_name'),
                    AllowedFilter::partial('last_name'),
                    AllowedFilter::partial('email'),
                    AllowedFilter::exact('flight_id'),
                ])
                ->allowedSorts(['flight_id', 'first_name', 'last_name', 'email', 'dob', 'passport_expiry_date'])
                ->paginate($perPage)
                ->appends($request->query());
        });

        return response()->json([
            'success' => true,
            'data' => $passengers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:passengers,email',
            'password' => 'required|string|min:6',
            'dob' => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $passenger = Passenger::create($validated);

        return response()->json([
            'success' => true,
            'data' => $passenger,
        ], 201);
    }

    public function show(Passenger $passenger)
    {
        return response()->json([
            'success' => true,
            'data' => $passenger,
        ]);
    }

    public function update(Request $request, Passenger $passenger)
    {
        $validated = $request->validate([
            'flight_id' => 'sometimes|exists:flights,id',
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:passengers,email,' . $passenger->id,
            'password' => 'sometimes|string|min:6',
            'dob' => 'sometimes|date',
            'passport_expiry_date' => 'sometimes|date',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $passenger->update($validated);

        return response()->json([
            'success' => true,
            'data' => $passenger,
        ]);
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();

        return response()->json([
            'success' => true,
            'message' => 'Passenger deleted successfully.',
        ]);
    }
}
