<?php 
  $h1 = $seo->h1;
  $title = ($seo->meta_title!='')?$seo->meta_title:$h1;
  $extendData = array(
    'meta_title' => $seo->meta_title,
    'meta_keyword' => $seo->meta_keyword,
    'meta_description' => $seo->meta_description,
    'meta_image' => $seo->meta_image,
    'pagePrev' => (isset($data) && $data->lastPage() > 1)?$data->previousPageUrl():null,
    'pageNext' => (isset($data) && $data->lastPage() > 1)?$data->nextPageUrl():null
  );
?>
@extends('site.layouts.master', $extendData)

@section('title', $title)

@section('content')

<?php
  $breadcrumb = array(
    ['name' => $h1, 'link' => '']
  );
?>
@include('site.common.breadcrumb', $breadcrumb)

<div class="box-style mb-3">
  <h1 class="d-inline-flex py-2">{{ $h1 }}</h1>
</div>

<p class="mb-3">Danh sách kết quả tìm kiếm theo tên phim hoặc tên hãng phim.</p>

@if(isset($data) && $data->lastPage() > 0)

  @include('site.post.card', array('data' => $data, 'authors' => $authors))

  @if($data->lastPage() > 1)
    @include('site.common.paginate', ['paginator' => $data])
  @endif

@else
  <div class="alert alert-warning" role="alert">
    Không tìm thấy kết quả nào phù hợp
  </div>
@endif

@endsection