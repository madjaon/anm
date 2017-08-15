<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex,nofollow,noodp" />
  <meta name="language" content="vietnamese" />
  <title>@yield('title')</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{!! url('img/apple-touch-icon.png') !!}">
  <link rel="icon" type="image/png" sizes="32x32" href="{!! url('img/favicon-32x32.png') !!}">
  <link rel="icon" type="image/png" sizes="16x16" href="{!! url('img/favicon-16x16.png') !!}">
  <link rel="manifest" href="{!! url('img/manifest.json') !!}">
  <link rel="mask-icon" href="{!! url('img/safari-pinned-tab.svg') !!}" color="#5bbad5">
  <link rel="shortcut icon" href="{!! url('img/favicon.ico') !!}">
  <meta name="apple-mobile-web-app-title" content="Truyen On">
  <meta name="application-name" content="Truyen On">
  <meta name="msapplication-config" content="{!! url('img/browserconfig.xml') !!}">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="{!! asset('css/appp.css') !!}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.3.min.js" integrity="sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  @if(request()->segment(2) != 'login')
  <script src="https://www.google.com/recaptcha/api.js?hl=vi" async defer></script>
  <script>
    function onSubmit(token) {
      document.getElementById("reform").submit();
    }
  </script>
  @endif
</head>
<body>

<header class="mb-3">
  <div class="container">
    <div class="row">
      <div class="col">
      <ul class="list-unstyled text-center p-0 m-1 d-flex justify-content-center align-items-center">
          <li class="d-inline-block m-2 mr-3"><a href="{{ url('/') }}" class="" title="Trang Chủ"><i class="fa fa-home mr-1" aria-hidden="true"></i>Trang Chủ</a></li>
          <li class="d-inline-block m-2 mr-3"><a href="{{ url('user') }}" class="" title="Tài Khoản"><i class="fa fa-user-circle mr-1" aria-hidden="true"></i>Tài Khoản</a></li>
          <li class="d-inline-block m-2 mr-3"><a href="{{ url('user/compose') }}" class="" title="Viết Truyện"><i class="fa fa-edit mr-1" aria-hidden="true"></i>Viết Truyện</a></li>
          @if(Auth::guard('users')->check())
          <li class="d-inline-block m-2 mr-3"><a href="{{ url('user/logout') }}" class="" title="Đăng Xuất"><i class="fa fa-sign-out mr-1" aria-hidden="true"></i>Đăng Xuất</a></li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</header>

<div class="container mb-3">
  <div class="row">
    <div class="col">
      <div class="content">
        @yield('body')
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="container">
    <div class="row">
      <div class="col">
        <p>© MMXVII / <span class="made-with-love">Made with ❤ Books</span> / <a href="{!! url('/contact') !!}" title="Contact">Contact</a> / <a href="{!! url('/privacy-policy') !!}" title="Privacy policy">Privacy policy</a> / <a href="{!! url('/terms-of-use') !!}" title="Terms of use">Terms of use</a> / <a href="#" title="Lên đầu trang" rel="nofollow">Lên đầu trang</a></p>
      </div>
    </div>
  </div>
</footer>

</body>
</html>
