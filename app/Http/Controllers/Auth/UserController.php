<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function user(Request $request)
    {
        return response()->json(Auth::user());

    }


}
