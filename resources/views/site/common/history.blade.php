@if(isset($data))
<?php 
	$image = ($post->image)?CommonMethod::getThumbnail($post->image, 2):'/img/img2.jpg';
	$kind = CommonOption::getKindPost($post->kind);
	if($post->kind == SLUG_POST_KIND_UPDATING) {
		$badge = 'primary';
		$badgeText = 'Tập ' . $post->episode;
	} else {
		$badge = 'success';
		$badgeText = $kind . ' ' . $post->episode;
	}
?>
<div class="box-style mb-3">
	<div class="d-inline-flex py-2 title">Đã Xem</div>
</div>
<div class="box p-3 mb-3 animated fadeInDownNew">
	<div class="media d-flex justify-content-center align-items-center">
		<a href="{!! $data->url !!}" title="{!! $post->name !!}">
			<img class="d-flex mr-3 img-fluid rounded-circle" src="{!! url($image) !!}" alt="{!! $post->name !!}">
		</a>
		<div class="media-body">
			<p class="mt-0 mb-3"><a href="{!! $data->url !!}" title="{!! $post->name !!}">{!! $post->name !!} - {!! $data->epchapName !!}</a></p>
			<div class="d-flex align-items-center">
				<span class="badge badge-{!! $badge !!}">{!! $badgeText !!}</span>
			</div>
		</div>
	</div>
</div>
@endif