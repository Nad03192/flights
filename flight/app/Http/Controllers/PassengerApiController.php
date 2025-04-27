<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerApiController extends Controller
{
    public function index()
    {
        return Passenger::all();
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

        $validated['password'] = bcrypt($validated['password']); // hash password

        $passenger = Passenger::create($validated);

        return response()->json($passenger, 201);
    }

    public function show(Passenger $passenger)
    {
        return $passenger;
    }

    public function update(Request $request, Passenger $passenger)
    {
        $validated = $request->validate([
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

        return response()->json($passenger);
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();

        return response()->json(null, 204);
    }
}
