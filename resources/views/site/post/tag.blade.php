<?php 
  $h1 = $tag->h1;
  $title = ($tag->meta_title!='')?$tag->meta_title:$h1;
  $extendData = array(
    'meta_title' => $tag->meta_title,
    'meta_keyword' => $tag->meta_keyword,
    'meta_description' => $tag->meta_description,
    'meta_image' => $tag->meta_image,
    'pagePrev' => ($data->lastPage() > 1)?$data->previousPageUrl():null,
    'pageNext' => ($data->lastPage() > 1)?$data->nextPageUrl():null
  );
?>
@extends('site.layouts.master', $extendData)

@section('title', $title)

@section('content')

<?php
  $breadcrumb = array(
    ['name' => 'Danh sách hãng phim', 'link' => url('hang-phim')],
    ['name' => $h1, 'link' => '']
  );
?>
@include('site.common.breadcrumb', $breadcrumb)

<div class="box-style mb-3">
  <h1 class="d-inline-flex py-2">{!! $h1 !!}</h1>
</div>

@if($tag->patterns)<div class="description mb-3">{!! $tag->patterns !!}</div>@endif
@if($tag->summary)<div class="description mb-3">{!! $tag->summary !!}</div>@endif
@if($tag->description)<div class="description mb-3">{!! $tag->description !!}</div>@endif

@include('site.post.grid', array('data' => $data))

@if($data->lastPage() > 1)
  @include('site.common.paginate', ['paginator' => $data])
@endif

@endsection