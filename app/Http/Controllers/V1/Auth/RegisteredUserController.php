<?php
namespace App\Http\Controllers\V1\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create($request->validated());
        event(new Registered($user));
        Auth::login($user);
        return response()->json(['message' => 'OK'], 200);
    }
}
