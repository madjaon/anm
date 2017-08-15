@if(count($errors) > 0)
    <div class="alert alert-danger alert-block">
        <i class="fa fa-check"></i>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <b>Error!</b>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success alert-block">
        <i class="fa fa-check"></i>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <b>Success!</b> {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <b>Warning!</b> {{ Session::get('warning') }}
    </div>
@endif
