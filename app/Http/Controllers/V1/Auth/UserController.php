<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Resources\V1\User\CurrentUserResource;
use Illuminate\Http\Request;

class UserController
{
    public function user(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        return response()->json(['user'=>new CurrentUserResource($user), 'permissions'=>$user->jsPermissions()]);
    }
}
