<?php 
  $h1 = $type->h1;
  $title = ($type->meta_title!='')?$type->meta_title:$h1;
  $extendData = array(
    'meta_title' => $type->meta_title,
    'meta_keyword' => $type->meta_keyword,
    'meta_description' => $type->meta_description,
    'meta_image' => $type->meta_image,
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

@if($type->patterns)<div class="description mb-3">{!! $type->patterns !!}</div>@endif
@if($type->summary)<div class="description mb-3">{!! $type->summary !!}</div>@endif
@if($type->description)<div class="description mb-3">{!! $type->description !!}</div>@endif

@include('site.post.grid', array('data' => $data))

@if($data->lastPage() > 1)
  @include('site.common.paginate', ['paginator' => $data])
@endif

@endsection