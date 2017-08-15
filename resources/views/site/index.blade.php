<?php 
  if(isset($seo)) {
    $title = ($seo->meta_title)?$seo->meta_title:'Trang chủ';
    $meta_title = $seo->meta_title;
    $meta_keyword = $seo->meta_keyword;
    $meta_description = $seo->meta_description;
    $meta_image = $seo->meta_image;
  } else {
    $title = 'Trang chủ';
    $meta_title = '';
    $meta_keyword = '';
    $meta_description = '';
    $meta_image = '';
  }
  $extendData = array(
      'meta_title' => $meta_title,
      'meta_keyword' => $meta_keyword,
      'meta_description' => $meta_description,
      'meta_image' => $meta_image,
      'isHome' => true
    );
?>
@extends('site.layouts.master', $extendData)

@section('title', $title)

@section('content')

@include('site.common.ad', ['posPc' => 7, 'posMobile' => 8])

<!--history-->

@if($configtoptrending)
<div class="box-style mb-3">
  <div class="d-inline-flex py-2 title">Xu Hướng</div>
</div>
@include('site.post.grid', array('data' => $configtoptrending))
@endif

<div class="box-style mb-3">
  <div class="d-inline-flex py-2 title">Mới Nhất</div>
</div>
@include('site.post.grid', array('data' => $data))

@include('site.common.ad', ['posPc' => 9, 'posMobile' => 10])

@endsection