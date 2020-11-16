<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Registered;
use App\Registrado;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
        /*if (\Request::has("data")){
            $params = json_decode(\Request::get('data'));

            \Request::merge(['password' => $params->data->formData[0]->value]);
            \Request::merge(['password_confirmation' => $params->data->formData[0]->value]);
            \Request::merge(['token' => $params->data->formData[2]->value]);
        }*/
    }

    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        if ($user = Registrado::where('email', $request->input('email'))->first()) {
            $this->resetPassword($user, $request->input('password'));
            \DB::table('password_resets')->where('token', $request->get('token'))->delete();
            return $this->sendResetResponse(null);
        } else {
            return $this->sendResetFailedResponse($request, null);
        }
    }

    protected function resetPassword($user, $password)
    {
        $user->password = $password;

        $user->setRememberToken(Str::random(60));

        $user->save();

        //event(new PasswordReset($user));

        //$this->guard()->login($user);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        $responseArray['success'] = true;
        $responseArray['data']['createPass'] = 3;
        $responseArray['data']['message'] = trans('front.pages.forgotPassword.page_recover_token_not_mach');

        return json_encode($responseArray);
    }

    protected function sendResetResponse($response)
    {
        $responseArray['success'] = true;
        $responseArray['data']['createPass'] = 1;
        $responseArray['data']['message'] = trans('front.pages.forgotPassword.page_recover_change_success');
        return json_encode($responseArray);
    }
}
