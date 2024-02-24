<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token', $user->getRoleNames()->toArray())->plainTextToken;
        $expiration = now()->addMinutes(config('sanctum.expiration'));

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
            'expires_in' => $expiration->timestamp
        ], 200);
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

}
