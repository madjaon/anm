<?php 
  $h1 = $seri->h1;
  $title = ($seri->meta_title!='')?$seri->meta_title:$h1;
  $extendData = array(
    'meta_title' => $seri->meta_title,
    'meta_keyword' => $seri->meta_keyword,
    'meta_description' => $seri->meta_description,
    'meta_image' => $seri->meta_image,
    'pagePrev' => ($data->lastPage() > 1)?$data->previousPageUrl():null,
    'pageNext' => ($data->lastPage() > 1)?$data->nextPageUrl():null
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
  <h1 class="d-inline-flex py-2">{!! $h1 !!}</h1>
</div>

@if($seri->patterns)<div class="description mb-3">{!! $seri->patterns !!}</div>@endif
@if($seri->summary)<div class="description mb-3">{!! $seri->summary !!}</div>@endif
@if($seri->description)<div class="description mb-3">{!! $seri->description !!}</div>@endif

@include('site.post.grid', array('data' => $data))

@if($data->lastPage() > 1)
  @include('site.common.paginate', ['paginator' => $data])
@endif

@endsection