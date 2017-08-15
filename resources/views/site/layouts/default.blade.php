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

<div class="container">
  @yield('content')
</div>

@include('site.common.bottom')

</body>
</html>
