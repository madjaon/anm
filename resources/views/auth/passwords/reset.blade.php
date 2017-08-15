@extends('auth.layouts.master')

@section('title', 'Reset Password')

@section('body')
    <div class="row">
        <div class="col-sm-6">
            <div class="box-style mb-3">
                <div class="d-inline-flex py-2 title">@yield('title')</div>
            </div>
            @include('auth.common.errors')
            <form class="form-horizontal" role="form" method="POST" action="{{ url(Request::segment(1) . '/password/reset') }}" id="reform">
                {!! csrf_field() !!}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input name="email" type="email" value="{{ $email or old('email') }}" class="form-control" placeholder="Nhập Địa Chỉ Email" maxlength="255" required>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input name="password" type="password" class="form-control" placeholder="Mật Khẩu" maxlength="255" required>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input name="password_confirmation" type="password" class="form-control" placeholder="Nhập Lại Mật Khẩu" maxlength="255" required>
                </div>

                <div class="form-group d-flex align-items-center">
                    <!-- <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-refresh mr-1"></i>Lấy Lại Mật Khẩu</button> -->
                    <button class="btn btn-primary g-recaptcha" data-sitekey="{{ RECAPTCHASITEKEY }}" data-callback="onSubmit"><i class="fa fa-btn fa-refresh mr-1"></i>Lấy Lại Mật Khẩu</button>
                    @if(!Auth::guard('users')->check())
                    <a href="{{ url('user/login') }}" class="ml-3">Đăng Nhập</a>
                    <a href="{{ url('user/register') }}" class="ml-3">Đăng Ký Tài Khoản</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-sm-6"></div>
    </div>
@endsection
