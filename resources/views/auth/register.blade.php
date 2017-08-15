@extends('auth.layouts.master')

@section('title', 'Đăng Ký Tài Khoản Viết Truyện')

@section('body')
    <div class="row">
        <div class="col-sm-6">
            <div class="box-style mb-3">
                <div class="d-inline-flex py-2 title">@yield('title')</div>
            </div>
            @include('auth.common.errors')
            <form action="{{ url('user/register') }}" method="post" id="reform">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input name="name" type="text" value="{{ old('name') }}" class="form-control" placeholder="Bút Danh" maxlength="255" required>
                </div>
                <div class="form-group">
                    <input name="username" type="text" value="{{ old('username') }}" class="form-control" placeholder="Tên Đăng Nhập" maxlength="255" required>
                </div>
                <div class="form-group">
                    <input name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="Email" maxlength="255" required>
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Mật Khẩu" maxlength="255" required>
                </div>
                <div class="form-group">
                    <input name="password_confirmation" type="password" class="form-control" placeholder="Nhập Lại Mật Khẩu" maxlength="255" required>
                </div>
                <div class="form-group d-flex align-items-center">
                    <!-- <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-sign-in mr-1"></i>Đăng Ký</button> -->
                    <button class="btn btn-primary g-recaptcha" data-sitekey="{{ RECAPTCHASITEKEY }}" data-callback="onSubmit"><i class="fa fa-btn fa-sign-in mr-1"></i>Đăng Ký</button>
                    <a href="{{ url('user/login') }}" class="ml-3">Sẵn Sàng Đăng Nhập?</a>
                </div>
            </form>
        </div>
        <div class="col-sm-6"></div>
    </div>
@endsection
