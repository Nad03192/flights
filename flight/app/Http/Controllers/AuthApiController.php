<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Role; // Optional, if you are assigning roles

class AuthApiController extends Controller
{
    // Register User
    public function register(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Optionally, assign default role after registration (if roles are set up)
        $user->assignRole('user'); // This assumes the 'user' role exists

        // Return success response
        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201);
    }

    // Login User
    public function login(Request $request)
    {
        // Validate the login credentials
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists and credentials are correct
        if (Auth::attempt($validated)) {
            // Get the authenticated user
            $user = Auth::user();
            
            // Generate a token (API token)
            $token = $user->createToken('YourAppName')->plainTextToken;

            // Return the token
            return response()->json([
                'message' => 'Login successful!',
                'token' => $token,
                'user' => $user,
            ]);
        }

        // If authentication fails
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // Logout User
    public function logout(Request $request)
    {
        // Revoke the token of the currently authenticated user
        $request->user()->currentAccessToken()->delete();

        // Return success response
        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
