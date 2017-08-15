@extends('auth.layouts.master')

@section('title', 'Reset Password')

<!-- Main Content -->
@section('body')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="row">
    <div class="col-sm-6">
        <div class="box-style mb-3">
            <div class="d-inline-flex py-2 title">@yield('title')</div>
        </div>
        @include('auth.common.errors')
        <form class="form-horizontal" role="form" method="POST" action="{{ url(Request::segment(1) . '/password/email') }}" id="reform">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="Nhập Địa Chỉ Email" maxlength="255" required>
            </div>
            <div class="form-group d-flex align-items-center">
                <!-- <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-envelope mr-1"></i>Gửi Link Lấy Lại Mật Khẩu</button> -->
                <button class="btn btn-primary g-recaptcha" data-sitekey="{{ RECAPTCHASITEKEY }}" data-callback="onSubmit"><i class="fa fa-btn fa-envelope mr-1"></i>Gửi Link Lấy Lại Mật Khẩu</button>
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
