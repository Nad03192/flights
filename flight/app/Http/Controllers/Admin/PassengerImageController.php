<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PassengerImageController extends Controller
{
    public function store(Request $request, Passenger $passenger)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);


        if ($passenger->image) {
            Storage::disk('public')->delete($passenger->image);
        }

        $path = $request->file('image')->store('passenger_images', 'public');
        $passenger->image = $path;
        $passenger->save();

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully.',
            'data' => ['image_path' => $path],
        ]);
    }

    public function destroy(Passenger $passenger)
    {
        if (!$passenger->image) {
            return response()->json([
                'success' => false,
                'message' => 'No image to delete.',
            ], 404);
        }

        Storage::disk('public')->delete($passenger->image);
        $passenger->image = null;
        $passenger->save();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
        ]);
    }
}
