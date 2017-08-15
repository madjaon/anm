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

<p class="mb-3">Tìm nhanh tên hãng phim, bạn ấn CTRL + F để sử dụng ô tìm kiếm.</p>

<div class="row">
  <div class="col">
    <table class="table table-bordered">
      <thead>
        <tr><th class="align-middle px-3">Tên hãng phim</th><th width="100" class="align-middle text-center">&nbsp;</th></tr>
      </thead>
      <tbody>
        @foreach($data as $value)
        <tr>
          <td class="align-middle px-3"><a href="{!! CommonUrl::getUrlPostTag($value->slug) !!}" title="{!! $value->name !!}">{!! $value->name !!}</a></td>
          <td class="align-middle text-center"><a href="{!! CommonUrl::getUrlPostTag($value->slug) !!}" title="{!! $value->name !!}">Xem</a></td>
        </tr>
        @endforeach 
      </tbody>
    </table>
  </div>
</div>

@if($data->lastPage() > 1)
  @include('site.common.paginate', ['paginator' => $data])
@endif

@endsection