<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
        try{
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'user crated successfully',
                'data' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login()
    {
        try{
            $credentials = request(['email', 'password']);

            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
