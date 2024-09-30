<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function allUsersAmount(): int
    {
        return User::with('orders')->count();
    }
}
