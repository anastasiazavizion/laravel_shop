<?php

namespace App\Http\Controllers\V1\Auth;

use Illuminate\Http\Request;

class UserController
{
    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json(['user'=>$user, 'permissions'=>$user->jsPermissions()]);

    }
}
