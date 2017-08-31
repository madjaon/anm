@if(!empty($data))
<div class="row">
  @foreach($data as $key => $value)
    <?php 
      $url = url($value->slug);
      $image = ($value->image)?CommonMethod::getThumbnail($value->image, 1):'/img/img.jpg';
      $typePostName = CommonOption::getTypePost($value->type);
      if($value->kind == SLUG_POST_KIND_UPDATING) {
        $badge = 'primary';
        $badgeText = 'Tập ' . $value->episode;
      } else {
        $badge = 'success';
        $badgeText = 'Full ' . $value->episode;
      }
    ?>
    <div class="col-6 col-sm-3 col-five mb-2">
      <figure class="figure text-center grid-item h-100">
        <a href="{{ $url }}" title="{{ $value->name }}" class="d-block">
          <img src="{{ url($image) }}" class="figure-img img-fluid" alt="{{ $value->name }}">
          <span class="badge badge-{{ $badge }}">{{ $badgeText }}</span>
          <span class="badge badge-danger">{{ $typePostName . '. ' . $value->year }}</span>
        </a>
        <figcaption class="figure-caption">
          <a href="{{ $url }}" title="{{ $value->name }}">{{ $value->name }}</a>
        </figcaption>
      </figure>
    </div>
  @endforeach
</div>
@else
<div class="alert alert-warning" role="alert">
  <strong>Chú ý!</strong> Đang cập nhật dữ liệu. Mời bạn quay lại sau!
</div>
@endif