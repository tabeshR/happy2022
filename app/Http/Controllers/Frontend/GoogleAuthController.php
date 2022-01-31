<?php

namespace App\Http\Controllers\Frontend;

use App\Http\CheckTwoFactorAuth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    use CheckTwoFactorAuth;
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $google_user = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $google_user->email)->first();
        if (!$user) {
          $user = User::create([
              'email' => $google_user->email,
              'password' => bcrypt(Str::random(10)),
              'avatar' => $google_user->avatar,
              'name' => $google_user->name
          ]);
        }
        if($user && is_null($user->avatar)){
            $user->update([
                'avatar' => $google_user->avatar
            ]);
        }

        auth()->loginUsingId($user->id);
        return $this->check($user) ?: redirect(route('profile'));


    }
}
