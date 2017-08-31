<?php 
  $h1 = $data->h1;
  $title = ($data->meta_title!='')?$data->meta_title:$h1;
  $extendData = array(
    'meta_title' => $data->meta_title,
    'meta_keyword' => $data->meta_keyword,
    'meta_description' => $data->meta_description,
    'meta_image' => $data->meta_image,
  );
?>
@extends('site.layouts.default', $extendData)

@section('title', $title)

@section('content')

<div class="row">
  <div class="col">

	<h1 class="my-3">{{ $h1 }}</h1>

	@include('site.common.errors')

	@if(!empty($data->patterns))<div class="description">{!! $data->patterns !!}</div>@endif
	@if(!empty($data->summary))<div class="description">{!! $data->summary !!}</div>@endif
	@if(!empty($data->description))<div class="description">{!! $data->description !!}</div>@endif

	</div>
</div>
@endsection