@include('site.common.head')
<body>

@if(isset($isPost) && !empty($configfbappid))
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{!! $configfbappid !!}',
      xfbml      : true,
      version    : 'v2.9'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
@endif

@include('site.common.top')

@include('site.common.ad', ['posPc' => 1, 'posMobile' => 2])

<div class="container">
  @yield('content')
</div>

@include('site.common.ad', ['posPc' => 3, 'posMobile' => 4])

@include('site.common.bottom')

@if(getDevice2() == PC && (CommonQuery::checkAdByPosition(5) || CommonQuery::checkAdByPosition(6)))
  <div class="scrollSticky" id="scrollLeft" data-top="110">
    @include('site.common.ad', ['posPc' => 5])
  </div>
  <div class="scrollSticky" id="scrollRight" data-top="110">
    @include('site.common.ad', ['posPc' => 6])
  </div>
  @push('scroll')
    <script src="{!! asset('js/s.js') !!}"></script>
    <!-- <style>@media(min-width:1200px){.container{width:1000px;}}</style> -->
  @endpush
@endif

</body>
</html>
