@if(!empty($data))
<div class="row">
  @foreach($data as $key => $value)
    <?php 
      $url = url($value->slug);
      $image = ($value->image)?CommonMethod::getThumbnail($value->image, 1):'/img/img3.jpg';
      $kind = CommonOption::getKindPost($value->kind);
      if($value->kind == SLUG_POST_KIND_UPDATING) {
        $badge = 'primary';
        $badgeText = 'Tập ' . $value->episode;
      } else {
        $badge = 'success';
        $badgeText = $kind . ' ' . $value->episode;
      }
    ?>
    <div class="col-6 col-sm-3">
      <figure class="figure text-center grid-item">
        <a href="{!! $url !!}" title="{!! $value->name !!}" class="d-block">
          <img src="{!! url($image) !!}" class="figure-img img-fluid" alt="{!! $value->name !!}">
          <span class="badge badge-{!! $badge !!}">{!! $badgeText !!}</span>
          <span class="badge badge-danger">{!! CommonMethod::numberFormatDot($value->view) !!} lượt xem</span>
        </a>
        <figcaption class="figure-caption">
          <a href="{!! $url !!}" title="{!! $value->name !!}">{!! $value->name !!}</a>
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