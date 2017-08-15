<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Auth\AuthController as Controller;
use App\Models\User;
use Validator;
use App\Helpers\CommonMethod;

class AuthController extends Controller
{
    protected $guard = 'users';
    protected $redirectTo = 'user';
    protected $username = 'username';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'bail|required|max:255|min:3|unique:users',
            'username' => 'bail|required|max:255|min:3|unique:users',
            'email' => 'bail|required|email|max:255|min:6|unique:users',
            'password' => 'bail|required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $recaptcha = CommonMethod::recaptcha();
        if(!isset($recaptcha)) {
            redirect()->back()->with('warning', 'Xác nhận không đúng.');
        }

        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public function index()
    {
        return view('auth.index');
    }

    public function getRegister()
    {
        return view('auth.register');
    }
}
