<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\CheckTwoFactorAuth;
use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers,CheckTwoFactorAuth;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//    public function redirectPath()
//    {
//        if (method_exists($this, 'redirectTo')) {
//            return $this->redirectTo();
//        }
//
//        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/profile';
//    }

    protected function authenticated(Request $request, $user)
    {
       return $this->check($user);
    }
}
