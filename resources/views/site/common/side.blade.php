<!--history-->

@include('site.common.ad', ['posPc' => 11, 'posMobile' => 12])
<div class="side mb-5">
  <h2 class="mb-3">Xu Hướng <small class="text-muted">Top Trending</small></h2>
  <div class="trending mt-4">
    @if($configtoptrending)
    <ul class="list-unstyled">
      @foreach($configtoptrending as $value)
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
      <li class="media mb-3 pb-3 side-item">
        <a href="{!! $url !!}" title="{!! $value->name !!}">
          <img class="d-flex mr-3 img-fluid" src="{!! url($image) !!}" alt="{!! $value->name !!}">
        </a>
        <div class="media-body">
          <h3 class="mt-0 mb-2 side-item-title"><a href="{!! $url !!}" title="{!! $value->name !!}">{!! $value->name !!}</a></h3>
          <div class="d-flex align-items-center">
            <span class="badge badge-{!! $badge !!}">{!! $badgeText !!}</span>
          </div>
        </div>
      </li>
      @endforeach
    </ul>
    @endif
  </div>
</div>
@include('site.common.ad', ['posPc' => 13, 'posMobile' => 14])
