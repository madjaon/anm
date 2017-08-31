@if(count($errors) > 0)
  <div class="alert alert-dismissible alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Có lỗi xảy ra!</strong>
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
@if(Session::has('success'))
  <div class="alert alert-dismissible alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Thành công!</strong> {{ Session::get('success') }}
  </div>
@endif
@if(Session::has('warning'))
  <div class="alert alert-dismissible alert-warning" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Chú ý!</strong> {{ Session::get('warning') }}
  </div>
@endif
