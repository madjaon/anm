<html>
  <head>
    <meta charset="utf-8">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>test</title>
  </head>
  <body>
    <h1>myanimelist html string</h1>
    @if(Session::has('success'))
      <p style="color:green;">{!! Session::get('success') !!}</p>
    @endif
    <form action="{{ url('test/animeSteal') }}" method="post">
      {!! csrf_field() !!}
      <textarea name="htmlstring" class="form-control" rows="8" cols="60"></textarea>
      <!-- {!! Form::select('kind', CommonOption::kindPostArray(), old('kind')) !!} -->
      <!-- {!! Form::select('type', CommonOption::typePostArray(), old('type')) !!} -->
      {!! Form::select('year', CommonOption::yearArray(), old('year')) !!}
      {!! Form::select('season', CommonOption::seasonArray(), old('season')) !!}
      <br>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
