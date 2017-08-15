<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Auth\PasswordController as Controller;

class PasswordController extends Controller
{
    protected $broker = 'users';
    protected $redirectTo = 'user';
    protected $subject = 'Đặt Lại Mật Khẩu Tài Khoản';

}
