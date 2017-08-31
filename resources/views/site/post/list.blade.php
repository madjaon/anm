@if(!empty($data))
<div class="row mt-4">
  @foreach($data as $key => $value)
    <?php 
      $url = url($value->slug);
      $image = ($value->image)?CommonMethod::getThumbnail($value->image, 2):'/img/img2.jpg';
      $typePostName = CommonOption::getTypePost($value->type);
      if($value->kind == SLUG_POST_KIND_UPDATING) {
        $badge = 'primary';
        $badgeText = 'Tập ' . $value->episode;
      } else {
        $badge = 'success';
        $badgeText = 'Full ' . $value->episode;
      }
    ?>
    <div class="col-12 col-sm-6">
      <div class="media mb-3 pb-3 list-item">
        <a href="{{ $url }}" title="{{ $value->name }}">
          <img class="d-flex mr-3 img-fluid" src="{{ url($image) }}" alt="{{ $value->name }}">
        </a>
        <div class="media-body">
          <h2 class="mt-0 mb-3 list-item-title"><a href="{{ $url }}" title="{{ $value->name }}">{{ $value->name }}</a></h2>
          @if(!empty($authors[$key]))
          <small class="mb-2 text-muted d-block">Hãng sản xuất: {!! $authors[$key] !!}</small>
          @endif
          <div class="d-flex align-items-center">
            <span class="badge badge-{{ $badge }}">{{ $badgeText }}</span>
            <small class="ml-2 text-muted">{{ $typePostName . '. ' . $value->year }}</small>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
@else
<div class="alert alert-warning" role="alert">
  <strong>Chú ý!</strong> Đang cập nhật dữ liệu. Mời bạn quay lại sau!
</div>
@endif