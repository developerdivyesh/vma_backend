<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiAuthController extends Controller
{
    /**
     * Handle an API login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user || !Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
            return response()->json(
                ['message' => 'Incorrect credentials', 'status' => false], 401);
        }

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        // Prepare the response data
        $response = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
            'status' => true,
        ];

        // Return the response with user details and the token
        return response()->json($response, 200);
    }


    /**
     * Handle an API logout request.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}