<?php 
  $h1 = $post->h1;
  $title = ($post->meta_title!='')?$post->meta_title:$h1;
  $extendData = array(
    'meta_title' => $post->meta_title,
    'meta_keyword' => $post->meta_keyword,
    'meta_description' => $post->meta_description,
    'meta_image' => $post->meta_image,
    'isPost' => true
  );
  $image = ($post->image)?CommonMethod::getThumbnail($post->image, 1):'/img/img.jpg';
  $ratingCookieName = 'rating' . $post->id;
  $ratingCookie = isset($_COOKIE[$ratingCookieName])?$_COOKIE[$ratingCookieName]:null;
  $ratingValue = round($post->rating_value, 1, PHP_ROUND_HALF_UP);
  $ratingValueChecked = round($ratingValue, 0, PHP_ROUND_HALF_DOWN);
  $schemaUrl = ($post->type == POST_TV)?'http://schema.org/TVSeries':'http://schema.org/Movie';
?>
@extends('site.layouts.master', $extendData)

@section('title', $title)

@section('content')

<?php 
  $breadcrumb = array();
  foreach($post->types as $value) {
    $breadcrumb[] = ['name' => $value->name, 'link' => CommonUrl::getUrlPostType($value->slug)];
  }
  $breadcrumb[] = ['name' => $h1, 'link' => ''];
?>
@include('site.common.breadcrumb', $breadcrumb)

<div class="row book mb-3" itemscope itemtype="{{ $schemaUrl }}">
  <div class="col-6 col-sm-3 mx-auto">

    <img src="{{ url($image) }}" class="img-fluid mb-3 w-100" alt="{{ $post->name }}" itemprop="image">

    <div class="social mb-3">
      <div class="fb-like" data-share="true" data-show-faces="false" data-layout="button_count"></div>
    </div>
    
  </div>
  <div class="col-sm">

    <meta itemprop="url" content="{{ url($post->slug) }}">

    <h1 class="mb-3" itemprop="name">{{ $h1 }}</h1>

    @if(!empty($post->name2))
      <div class="mb-3 text-muted">{{ $post->name2 }}</div>
    @endif

    <?php 
      if($post->kind == SLUG_POST_KIND_UPDATING) {
        $badge = 'primary';
        $badgeText = 'Tập ' . $post->episode;
      } else {
        $badge = 'success';
        $badgeText = 'Full ' . $post->episode;
      }
    ?>
    <div class="book-info mb-3 d-flex align-items-center">
      <span class="badge badge-{{ $badge }}">{{ $badgeText }}</span>
      <span class="badge badge-secondary ml-2">{{ $post->typeName }}</span>
    </div>
   
    <div class="book-info mb-3"><span class="mr-1">Lượt xem:</span>{{ CommonMethod::numberFormatDot($post->view) }}</div>

    <div class="book-info mb-3">
      <div class="d-inline-block">
        <span class="mr-1">Năm:</span>
        @if($post->year > 0)
          <a href="{{ CommonUrl::getUrlPostYear($post->year) }}" title="{{ $post->year }}" itemprop="copyrightYear">{{ $post->year }}</a>
        @else
          <em>Không rõ</em>
        @endif
      </div>
      <div class="d-inline-block">
        <span class="ml-1 ml-sm-3 mr-1"><i class="fa fa-angle-right mr-2" aria-hidden="true"></i>Season:</span>
        @if(!empty($post->seasonYearName))
          <a href="{{ CommonUrl::getUrlPostSeasonYear($post->season, $post->year) }}" title="{{ $post->seasonYearName }}">{{ $post->seasonYearName }}</a>
        @else
          <em>Không rõ</em>
        @endif
      </div>
      <div class="d-inline-block mt-3 mt-md-0">
        <span class="ml-md-3 mr-1"><i class="fa fa-angle-right mr-2 d-none d-md-inline-block" aria-hidden="true"></i>Quốc Gia:</span>
        @if(!empty($post->nation))
          <a href="{{ CommonUrl::getUrlPostNation($post->nation) }}" title="{{ $post->nationName }}" itemprop="countryOfOrigin" itemscope itemtype="http://schema.org/Country"><span itemprop="name" content="{{ CommonOption::nationCode($post->nation) }}">{{ $post->nationName }}</span></a>
        @else 
          <em>Không rõ</em>
        @endif
      </div>
    </div>

    <div class="book-info mb-3"><span class="mr-1">Hãng sản xuất:</span>
      @if(!empty($post->tags))
        @foreach($post->tags as $key => $value)
          <?php echo ($key > 0)?'<span class="mx-2">-</span>':''; ?><a href="{{ CommonUrl::getUrlPostTag($value->slug) }}" title="{{ $value->name }}" itemprop="productionCompany" itemscope itemtype="http://schema.org/Organization"><span itemprop="name">{{ $value->name }}</span></a>
        @endforeach
      @else
        <em>Không rõ</em>
      @endif
    </div>

    <div class="book-info mb-3"><span class="mr-1">Thể Loại:</span>
      @foreach($post->types as $key => $value)
        <a href="{{ CommonUrl::getUrlPostType($value->slug) }}" title="{{ $value->name }}" itemprop="genre" class="badge badge-dark mr-1 mb-2">{{ $value->name }}</a>
      @endforeach
    </div>

    {{--<div class="book-info mb-3"><span class="mr-1">Nguồn:</span>
      @if(!empty($post->source))
        {{ $post->source }}
      @else 
        <em>Không rõ</em>
      @endif
    </div>--}}

    @if(isset($post->epFirst) || isset($post->epLast))
      @if(($post->epFirst->id == $post->epLast->id) || $post->type != POST_TV)
        <div class="row">
          <div class="col-md-6">
            <a class="btn btn-danger mb-3 w-100 book-full" href="{{ CommonUrl::getUrl2($post->slug, $post->epFirst->slug) }}"><i class="fa fa-video-camera mr-2" aria-hidden="true"></i>Xem Ngay</a>
          </div>
        </div>
      @else
        <div class="row">
          <div class="col-md-6">
            <a class="btn btn-info mb-3 w-100 book-first" href="{{ CommonUrl::getUrl2($post->slug, $post->epFirst->slug) }}">Xem Từ Tập Đầu</a>
          </div>
          <div class="col-md-6">
            <a class="btn btn-danger mb-3 w-100 book-last" href="{{ CommonUrl::getUrl2($post->slug, $post->epLast->slug) }}">Xem Tập Mới Nhất</a>
          </div>
        </div>
      @endif
    @else
    <div class="row">
      <div class="col-md-6">
        <a class="btn btn-secondary mb-3 w-100 book-comming">Phim Sắp Có Nhé</a>
      </div>
    </div>
    @endif
  </div>

  <div class="col-12 my-3">
    <div class="d-block d-sm-flex justify-content-center align-items-center text-center">
      <div class="d-flex justify-content-center align-items-center mr-3 mb-0" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <em><span id="ratingValue" itemprop="ratingValue">{{ $ratingValue }}</span> điểm / <span id="ratingCount" itemprop="ratingCount">{{ $post->rating_count }}</span> lượt đánh giá</em>
        <meta itemprop="bestRating" content="10">
        <meta itemprop="worstRating" content="1">
      </div>
      <form class="d-flex justify-content-center align-items-center" name="ratingfrm">
        <fieldset class="starability-growRotate">
          <input type="radio" id="growing-rate1" name="rating" value="1" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 1) checked @endif>
          <label for="growing-rate1" title="Quá tệ hại">1 star</label>
          <input type="radio" id="growing-rate2" name="rating" value="2" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 2) checked @endif>
          <label for="growing-rate2" title="Tốn thời gian">2 stars</label>
          <input type="radio" id="growing-rate3" name="rating" value="3" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 3) checked @endif>
          <label for="growing-rate3" title="Không thể hiểu">3 stars</label>
          <input type="radio" id="growing-rate4" name="rating" value="4" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 4) checked @endif>
          <label for="growing-rate4" title="Thiếu gia vị">4 stars</label>
          <input type="radio" id="growing-rate5" name="rating" value="5" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 5) checked @endif>
          <label for="growing-rate5" title="Cũng tàm tạm">5 stars</label>
          <input type="radio" id="growing-rate6" name="rating" value="6" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 6) checked @endif>
          <label for="growing-rate6" title="Cũng được">6 stars</label>
          <input type="radio" id="growing-rate7" name="rating" value="7" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 7) checked @endif>
          <label for="growing-rate7" title="Khá hay">7 stars</label>
          <input type="radio" id="growing-rate8" name="rating" value="8" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 8) checked @endif>
          <label for="growing-rate8" title="Cực hay">8 stars</label>
          <input type="radio" id="growing-rate9" name="rating" value="9" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 9) checked @endif>
          <label for="growing-rate9" title="Siêu phẩm">9 stars</label>
          <input type="radio" id="growing-rate10" name="rating" value="10" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 10) checked @endif>
          <label for="growing-rate10" title="Kiệt tác">10 stars</label>
        </fieldset>
        @push('starability')
          <link rel="stylesheet" href="{{ asset('css/starability.css') }}">
        @endpush
        @if(!isset($ratingCookie))
          <input type="hidden" id="p" value="{{ $post->id }}">
          @push('book')
            <script src="{{ asset('js/b.js') }}"></script>
          @endpush
        @endif
      </form>
    </div>
  </div>
</div>

@include('site.common.ad', ['posPc' => 15, 'posMobile' => 16])

<div class="box p-3 mb-3">

  @if(!empty($post->epsLastest))
  <div class="episodes mb-3">
    <h3 class="mb-3">Tập mới nhất</h3>
    @foreach($post->epsLastest as $value)
      <a href="{{ CommonUrl::getUrl2($post->slug, $value->slug) }}" title="{{ $value->name }}" class="btn btn-dark btn-sm mr-1 mb-2">{{ $value->name }}</a>
    @endforeach
  </div>
  @endif

  @if(!empty($post->seriData))
    <div class="my-5">
      <h3 class="seri mb-3"><a href="{{ CommonUrl::getUrlPostSeri($post->seriInfo->slug) }}" title="Seri phim {{ $post->seriInfo->name }}">Danh sách phim cùng Seri {{ $post->seriInfo->name }}</a></h3>
      <blockquote class="blockquote">
        <ul class="list-unstyled">
          @foreach($post->seriData as $value)
            <li>
              <a href="{{ url($value->slug) }}" title="{{ $value->name }}"><i class="fa fa-angle-right mr-2" aria-hidden="true"></i>{{ $value->name }}<span class="badge badge-primary ml-2 align-middle">{{ $value->year }}</span></a>
            </li>
          @endforeach
        </ul>
      </blockquote>
    </div>
  @endif

  @if(!empty($post->patterns))<div class="description mb-3">{!! $post->patterns !!}</div>@endif
  @if(!empty($post->summary))<div class="description mb-3">{!! $post->summary !!}</div>@endif
  @if(!empty($post->description))<div class="description mb-3">{!! $post->description !!}</div>@endif

</div>

@include('site.common.ad', ['posPc' => 17, 'posMobile' => 18])
  
<div class="comment mb-5">
  <div class="fb-comments" data-numposts="10" data-colorscheme="dark" data-width="100%" data-href="{{ url($post->slug) }}"></div>
</div>

@endsection