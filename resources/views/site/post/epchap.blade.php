<?php 
  $h1 = $data->h1;
  $title = ($data->meta_title!='')?$data->meta_title:$h1;
  $extendData = array(
    'meta_title' => $data->meta_title,
    'meta_keyword' => $data->meta_keyword,
    'meta_description' => $data->meta_description,
    'meta_image' => $data->meta_image,
    'isPost' => true,
    'isEpchap' => true
  );
?>
@extends('site.layouts.default', $extendData)

@section('title', $title)

@section('content')

<div class="row">
  <div class="col">

    <div class="d-flex justify-content-center align-items-center mx-auto mb-4 online"></div>

    <div class="text-center mb-3 d-flex-sm justify-content-center align-items-center">
      <div class="d-block d-sm-inline-block">
        <strong class="mr-2">Server</strong>
        {!! Form::select(null, $data->serverArray, $data->fs, array('class' =>'custom-select custom-select-sm m-2', 'style'=>'width:110px;', 'onchange'=>'epchap(this.value);')) !!}
      </div>

      @if(isset($data->epPrev))
        <input type="hidden" id="prev" value="{{ CommonUrl::getUrl2($post->slug, $data->epPrev->slug) }}">
        <a href="{{ CommonUrl::getUrl2($post->slug, $data->epPrev->slug) }}" class="btn btn-primary btn-sm m-2" rel="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i><span class="ml-2 d-none d-md-inline">Tập trước</span></a>
      @else
        <input type="hidden" id="prev" value="">
        <a class="btn btn-secondary btn-sm m-2 disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i><span class="ml-2 d-none d-md-inline">Tập trước</span></a>
      @endif

      {!! Form::select(null, $post->epchapArray, CommonUrl::getUrl2($post->slug, $data->slug), array('class' =>'custom-select custom-select-sm m-2', 'style'=>'width:110px;', 'onchange'=>'javascript:location.href = this.value;')) !!}

      @if(isset($data->epNext))
        <input type="hidden" id="next" value="{{ CommonUrl::getUrl2($post->slug, $data->epNext->slug) }}">
        <a href="{{ CommonUrl::getUrl2($post->slug, $data->epNext->slug) }}" class="btn btn-primary btn-sm m-2" rel="next"><span class="mr-2 d-none d-md-inline">Tập sau</span><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
      @else
        <input type="hidden" id="next" value="">
        <a class="btn btn-secondary btn-sm m-2 disabled"><span class="mr-2 d-none d-md-inline">Tập sau</span><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
      @endif
    </div>
  
    <div class="box p-3 mb-3">
      <?php 
        $breadcrumb = array();
        foreach($post->types as $value) {
          $breadcrumb[] = ['name' => $value->name, 'link' => CommonUrl::getUrlPostType($value->slug)];
        }
        $breadcrumb[] = ['name' => $post->name, 'link' => url($post->slug)];
        $breadcrumb[] = ['name' => $data->name, 'link' => ''];
      ?>
      @include('site.common.breadcrumb', $breadcrumb)

      @include('site.common.ad', ['posPc' => 19, 'posMobile' => 20])
      
      <h1 class="my-3">{{ $h1 }}</h1>

      @if(!empty($post->name2))
        <h2 class="mb-3 text-muted">{{ $post->name2 }}</h2>
      @endif
      
      <div class="mb-3" id="errormessage">
        <div class="spinner ml-2"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
        <button class="btn-danger badge badge-danger py-1 px-2 border-0" onclick="errorreporting()" id="errorreporting"><i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>Báo lỗi</button>
      </div>

      @if(!empty($post->epchapArray))
      <div class="episodes my-4">
        @foreach($post->epchapArray as $key => $value)
          <a href="{{ $key }}" title="{{ $post->name }} - {{ $value }}" class="btn btn-dark btn-sm mr-1 mb-2 <?php echo (CommonUrl::getUrl2($post->slug, $data->slug) == $key)?'disabled':'' ?>">{{ $value }}</a>
        @endforeach
      </div>
      @endif

      <div class="social mb-4">
        <div class="fb-like" data-share="true" data-show-faces="false" data-layout="button_count"></div>
      </div>

      @include('site.common.ad', ['posPc' => 21, 'posMobile' => 22])

      <div class="comment mb-5">
        <div class="fb-comments" data-numposts="10" data-colorscheme="dark" data-width="100%" data-href="{{ url($post->slug) }}"></div>
      </div>
      
      <input type="hidden" id="p" value="{{ $post->id }}">
      <input type="hidden" id="e" value="{{ $data->id }}">
      @push('epchap')
        <script src="{{ asset('js/e.js') }}"></script>
        <script src="//content.jwplatform.com/libraries/xSqZrvkA.js"></script>
      @endpush
    </div>
    
  </div>
</div>

@endsection