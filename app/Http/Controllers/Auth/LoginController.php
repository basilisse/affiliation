<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
  protected function attemptLogin(\Illuminate\Http\Request $request)
  {
    $credentials = $this->credentials($request);
    return $this->guard()->attemptWhen(
        $credentials,
        fn($user) => !$user->banned && $user->enabled,
        $request->has('remember')
    );
  }
  protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
  {
    $user = $this->guard()->getLastAttempted();

    throw ValidationException::withMessages([
        $this->username() => [
            $user && $this->guard()->getProvider()->validateCredentials($user, $this->credentials($request))
                ? 'Votre compte a été désactivé'
                : 'Vérifiez vos identifiants'
        ]
    ]);
  }

}
