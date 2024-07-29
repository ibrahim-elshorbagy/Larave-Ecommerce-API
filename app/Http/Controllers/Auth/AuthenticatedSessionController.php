<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

            // Attempt to authenticate using the LoginRequest
            $request->authenticate();

            // If authentication passes, proceed to token creation
            $user = $request->user();
            $user->tokens()->delete(); // Delete existing tokens if any

            // Create a new token
            $token = $user->createToken('API TOKEN');

            return response()->json([
                'user' => $user,
                'access_token' => $token->plainTextToken,
                'token_type' => 'Bearer',
            ]);
        try {
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.',
            ], 401);

        } catch (\Throwable $th) {
            // Handle other unexpected errors
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Revoke all tokens issued to the current user
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
