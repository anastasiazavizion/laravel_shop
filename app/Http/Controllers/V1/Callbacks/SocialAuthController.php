<?php
namespace App\Http\Controllers\V1\Callbacks;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $user = User::firstOrCreate(
            ['email'=>$userSocial->getEmail()],
            [
            'name' => $userSocial->getName() ?? $userSocial->getNickname(),
            'lastname' => '',
            'phone' => '',
            'birthday' => null,
            'email' => $userSocial->getEmail(),
            'password' => Str::password(6),
            'provider_name' => $provider,
            'provider_id'   => $userSocial->id,
            'provider_token' => $userSocial->token,
            'avatar' => $userSocial->avatar
        ]);
        Auth::login($user);
        return response()->json(['message' => 'OK'], 200);
    }
}
