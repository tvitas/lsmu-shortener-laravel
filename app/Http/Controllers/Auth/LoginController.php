<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Http\Controllers\Controller;
use App\Traits\AdDbAuthable;
use App\User;

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

    use AuthenticatesUsers, AdDbAuthable;

    private $inputUser;

    private $inputPass;

    protected $maxAttempts;

    protected $decayMinutes;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->maxAttempts = config('auth.providers.users.throttle.maxAttempts', 3);
        $this->decayMinutes = config('auth.providers.users.throttle.decayMinutes', 3);
        $this->redirectTo = config('shorts.redirect.auth', '/admin');

    }

    public function showLoginForm()
    {
        return view('auth.login_form');
    }
}
