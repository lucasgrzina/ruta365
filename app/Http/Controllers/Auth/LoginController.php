<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use InfyOm\Generator\Utils\ResponseUtil;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {

        $credentials = $request->only($this->username(), 'password','confirmado');
        // Customization: validate if client status is active (1)
        return $credentials;
    }

    public function login(Request $request)
    {
        $request->merge(['confirmado' => true]);
        
        $this->validateLogin($request);

        

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            // Customization: Validate if client status is active (1)
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $data = [
            'user' => $this->guard()->user(),
            'url_redirect' => false
        ];
        if (\Session::has('attemptedUrlFront')) {
            $data['url_redirect'] = \Session::get('attemptedUrlFront');
            \Session::forget('attemptedUrlFront');
        }
        //\FrontHelper::setCookie('codigoPaisUsuario', $data['user']->pais->abreviatura);
        return response()->json(ResponseUtil::makeResponse('La operación finalizó con éxito', $data));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        return redirect()->route('home');
    }
}
