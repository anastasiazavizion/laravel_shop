<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/sanctum/csrf-cookie",
 *     summary="Get CSRF token",
 *     description="This endpoint sets a CSRF token as a cookie. This is required for making authenticated requests to endpoints protected with Sanctum.",
 *     tags={"Authentication"},
 *     @OA\Response(
 *         response=204,
 *         description="CSRF token cookie set successfully.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="CSRF token cookie set successfully.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */

class AuthController
{
    /**
     *  @OA\Post(
     *      path="/api/v1/login",
     *      summary="Authenticate user and start a session",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="admin@gmail.com"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      example="password"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login successful, session started",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Authenticated"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Unauthorized"
     *              )
     *          )
     *      )
     *  )
     * /
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            session()->regenerate();
            return response()->json(['message' => 'Authenticated'], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
   }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return response()->json(['message' => 'Logout'], 200);
    }
}
