<div class="menubox animated zoomInDownNew">
  <div class="list-group">
    <a href="#" class="list-group-item list-group-item-action list-group-item-danger" title="Đóng Menu" onclick="document.getElementById('menumobile').style.display='none'"><i class="fa fa-window-close mr-2" aria-hidden="true"></i>Đóng Menu</a>
    <a href="{!! url('/') !!}" class="list-group-item list-group-item-action" title="Trang chủ"><i class="fa fa-home mr-2" aria-hidden="true"></i>Trang chủ</a>
    <a href="{!! CommonUrl::getUrlPostTV() !!}" class="list-group-item list-group-item-action" title="Danh sách TV Series"><i class="fa fa-check-square-o mr-2" aria-hidden="true"></i>TV Series</a>
    <a href="{!! CommonUrl::getUrlPostMovie() !!}" class="list-group-item list-group-item-action" title="Danh sách Movie"><i class="fa fa-check-square-o mr-2" aria-hidden="true"></i>Movie</a>
    <a href="{!! CommonUrl::getUrlPostKind('da-hoan-thanh') !!}" class="list-group-item list-group-item-action" title="Danh sách Phim đã hoàn thành"><i class="fa fa-check-square-o mr-2" aria-hidden="true"></i>Phim đã hoàn thành</a>
    <a href="{!! CommonUrl::getUrlPostKind('con-tiep-tuc') !!}" class="list-group-item list-group-item-action" title="Danh sách Phim còn tiếp tục"><i class="fa fa-square-o mr-2" aria-hidden="true"></i>Phim còn tiếp tục</a>
    <a href="{!! CommonUrl::getUrlStudio() !!}" class="list-group-item list-group-item-action" title="Danh sách hãng phim"><i class="fa fa-user-circle-o mr-2" aria-hidden="true"></i>Danh sách hãng phim</a>
    @foreach($data as $value)
      <a href="{!! CommonUrl::getUrlPostType($value->slug) !!}" class="list-group-item list-group-item-action" title="Thể loại {!! $value->name !!}">{!! $value->name !!}</a>
    @endforeach
    <a href="#" class="list-group-item list-group-item-action list-group-item-danger" title="Đóng Menu" onclick="document.getElementById('menumobile').style.display='none'"><i class="fa fa-window-close mr-2" aria-hidden="true"></i>Đóng Menu</a>
  </div>
</div>
