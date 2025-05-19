<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PassengerApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Passenger::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'asc');
        $query->orderBy($sortBy, $sortDir);

        $perPage = $request->get('per_page', 10);
        $passengers = $query->paginate($perPage);

        return response()->json($passengers);
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
            'image' => 'nullable|image|max:2048', // optional image
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('passenger_images', 'public');
        }

        $validated['password'] = bcrypt($validated['password']);

        $passenger = Passenger::create($validated);

        return response()->json($passenger, 201);
    }

    public function show(Passenger $passenger)
    {
        return response()->json($passenger);
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
            'image' => 'nullable|image|max:2048', // optional new image
        ]);

        if ($request->hasFile('image')) {
            if ($passenger->image) {
                Storage::disk('public')->delete($passenger->image);
            }
            $validated['image'] = $request->file('image')->store('passenger_images', 'public');
        }

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $passenger->update($validated);

        return response()->json($passenger);
    }

    public function destroy(Passenger $passenger)
    {
        if ($passenger->image) {
            Storage::disk('public')->delete($passenger->image);
        }

        $passenger->delete();

        return response()->json(null, 204);
    }
}
