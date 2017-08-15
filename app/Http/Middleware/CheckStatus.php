<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //If the status is not approved redirect to login 
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->status != ACTIVE) {
            Auth::guard('admin')->logout();
            return redirect('admin/login')->with('warning', 'Account suppend!');
        }
        // if(Auth::guard('users')->check() && Auth::guard('users')->user()->status != ACTIVE) {
        //     $note = Auth::guard('users')->user()->note;
        //     Auth::guard('users')->logout();
        //     return redirect('user/login')->with('warning', 'Tài khoản của bạn bị tạm khóa! Lý do ' . $note . ', thắc mắc xin liên hệ với chúng tôi.');
        // }

        return $response;
    }
}
