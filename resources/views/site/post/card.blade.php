@if(!empty($data))
<div class="row">
  <div class="col">
    <ul class="list-unstyled">
      @foreach($data as $key => $value)
      <?php 
        $url = url($value->slug);
        $image = ($value->image)?CommonMethod::getThumbnail($value->image, 2):'/img/img2.jpg';
        $kind = CommonOption::getKindPost($value->kind);
        if($value->kind == SLUG_POST_KIND_UPDATING) {
          $badge = 'primary';
          $badgeText = 'Tập ' . $value->episode;
        } else {
          $badge = 'success';
          $badgeText = $kind . ' ' . $value->episode;
        }
      ?>
      <li class="media mb-3 pb-3 card-item">
        <a href="{!! $url !!}" title="{!! $value->name !!}">
          <img class="d-flex mr-3 img-fluid" src="{!! url($image) !!}" alt="{!! $value->name !!}">
        </a>
        <div class="media-body">
          <h2 class="mt-0 mb-2 card-item-title"><a href="{!! $url !!}" title="{!! $value->name !!}">{!! $value->name !!}</a></h2>
          @if(!empty($authors[$key]))
          <div class="mb-2 authors">Hãng phim: {!! $authors[$key] !!}</div>
          @endif
          <div class="d-flex align-items-center">
            <span class="badge badge-{!! $badge !!}">{!! $badgeText !!}</span>
            <small class="ml-2 text-muted">{!! CommonMethod::numberFormatDot($value->view) !!} lượt xem</small>
          </div>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
</div>
@else
<div class="alert alert-warning" role="alert">
  <strong>Chú ý!</strong> Đang cập nhật dữ liệu. Mời bạn quay lại sau!
</div>
@endif