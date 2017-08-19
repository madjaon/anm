@if(isset($data))
<?php 
	$url = url($post->slug);
	$image = ($post->image)?CommonMethod::getThumbnail($post->image, 2):'/img/img2.jpg';
?>
<div class="box-style mb-3">
	<div class="d-inline-flex py-2 title">Đã Xem</div>
</div>
<div class="box p-3 mb-3 animated fadeInDownNew">
	<div class="media d-flex justify-content-center align-items-center">
		<a href="{!! $url !!}" title="{!! $post->name !!}">
			<img class="d-flex mr-3 img-fluid rounded-circle" src="{!! url($image) !!}" alt="{!! $post->name !!}">
		</a>
		<div class="media-body">
			<div class="mb-1"><a href="{!! $url !!}" title="{!! $post->name !!}" class="text-success"><strong>{!! $post->name !!}</strong></a><span class="ml-1 text-muted">({!! $post->year !!})</span></div>
			<span class="d-block mb-1">{!! $post->name2 !!}</span>
			<a href="{!! CommonUrl::getUrl2($post->slug, $data->slug) !!}" title="{!! $post->name . ' - ' . $data->name !!}" class="badge badge-danger py-1 px-2">Mở lại tập {!! $data->epchap !!}</a>
		</div>
	</div>
</div>
@endif