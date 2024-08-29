<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
class AuthController
{
    public function authenticate(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Authenticated'], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
   }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logout'], 200);
    }
}
