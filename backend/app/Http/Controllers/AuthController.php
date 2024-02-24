<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

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
        $token = $user->createToken(Str::random(10))->plainTextToken;
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
