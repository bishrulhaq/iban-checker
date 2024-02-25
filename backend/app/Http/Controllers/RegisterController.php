<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ])->validate();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('user');
            $token = $user->createToken(Str::random(10))->plainTextToken;
            $expiration = now()->addMinutes(config('sanctum.expiration'));

            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()->toArray(),
                ],
                'expires_in' => $expiration->timestamp,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration.',
            ], 500);
        }

    }
}
