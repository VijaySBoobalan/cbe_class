<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Institution;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return Validator::make($data, [
            'instution_name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255'],
            'phone_number_1' => ['required', 'numeric', 'min:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $Institution = Institution::create([
            'instution_name' => $data['instution_name'],
            'instution_address' => $data['instution_address'],
            'user_name' => $data['user_name'],
            'phone_number_1' => $data['phone_number_1'],
            'phone_number_2' => $data['phone_number_2'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $User = User::create([
            'name' => $Institution->instution_name,
            'email' => $Institution->email,
            'password' => $Institution->password,
            'user_id' => $Institution->id,
            'user_type' => 'Admin',
            'mobile_number' => $Institution->phone_number_1,
        ]);

        $User->assignRole(1);

        return $User;
    }
}
