<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\{User, UserDocuments, Role};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $previousUrl = URL::previous();
        $retailerRegisterUrl = url('/') . '/retailer/register';
        $validation = [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $message = [
            'name.required' => __('user.validations.nameRequired'),
            'name.string' => __('user.validations.nameString'),
            'name.max' => __('user.validations.nameMax'),
            'email.required' => __('user.validations.emailRequired'),
            'email.string' => __('user.validations.emailString'),
            'email.email' => __('user.validations.emailType'),
            'email.max' => __('user.validations.emailMax'),
            'email.unique' => __('user.validations.emailUnique'),
            'password.required' => __('user.validations.passwordRequired'),
            'password.string' => __('user.validations.passwordString'),
            'password.min' => __('user.validations.passwordMin'),
            'password.confirmed' => __('user.validations.passwordConfirmed'),
        ];

        if ($previousUrl == $retailerRegisterUrl) {
            $validation['type'] = ['required'];
            $validation['proof'] = ['required', 'mimes:jpg,jpeg,png', 'max:2048'];
            $message['type.required'] = __('user.validations.typeRequired');
            $message['proof.required'] = __('user.validations.proofRequired');
            $message['proof.image'] = __('user.validations.proofImage');
            $message['proof.mimes'] = __('user.validations.proofExtenstion');
            $message['proof.max'] = __('user.validations.proofSize');
        }

        
        return Validator::make($data, $validation, $message);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $previousUrl = URL::previous();
        $retailerRegisterUrl = url('/') . '/retailer/register';
        $signUpData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];
        $documents = [];
        if ($previousUrl == $retailerRegisterUrl) {
            $roleId = Role::where('name', $data['type'])->pluck('id')->firstOrFail();
            $signUpData['role_id'] = $roleId;
            $user = User::create($signUpData);
            $proof = request()->file('proof');
            $fileName = time() . '-user-'. $user->id."-proof." . $proof->getClientOriginalExtension();
            $filePath = $proof->storeAs('retailer', $fileName);
            $documents = [
                'file' => $filePath,
            ];
            $user->documents()->create($documents);

            return $user;

        } else {
            $roleId = Role::where('name', 'customer')->pluck('id')->firstOrFail();
            $signUpData['role_id'] = $roleId;
            
            return User::create($signUpData);
        }

    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($user->role->name == 'admin') {
            $this->redirectTo = 'admin/dashboard';
        } elseif ($user->role->name == 'individual' || $user->role->name == 'retailer') {
            $this->redirectTo = 'retailer/dashboard';
        }
        
        return redirect($this->redirectTo);
    }
}
