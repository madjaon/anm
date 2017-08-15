<?php 
  $h1 = $seo->h1;
  $title = ($seo->meta_title!='')?$seo->meta_title:$h1;
  $extendData = array(
    'meta_title' => $seo->meta_title,
    'meta_keyword' => $seo->meta_keyword,
    'meta_description' => $seo->meta_description,
    'meta_image' => $seo->meta_image,
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

@include('site.post.grid', array('data' => $data))

@if($data->lastPage() > 1)
  @include('site.common.paginate', ['paginator' => $data])
@endif

@endsection