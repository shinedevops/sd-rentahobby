<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Setting;
use Session;

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

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ],[
            $this->username().'.required' => __('user.validations.emailRequired'),
            $this->username().'.email' => __('user.validations.emailType'),
            $this->username().'.exists' => __('user.validations.invalidEmail'),
            'password.required' => __('user.validations.passwordRequired')
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role->name == 'admin') {
            $this->redirectTo = 'admin/dashboard';
        } elseif ($user->role->name == 'individual' || $user->role->name == 'retailer') {
            $this->redirectTo = 'retailer/dashboard';
        }
        $settings = Setting::all();

        foreach($settings as $setting) {
            Session::put($setting->key, $setting->value);
        }

        return redirect($this->redirectTo);
    }
}
