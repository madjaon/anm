@extends('admin.layouts.master')

@section('title', 'Generate Thumbnail Avatar Images')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="/admin/genthumb" class="btn btn-warning btn-sm">Gen Thumb</a>
		<a href="/admin/genwatermark" class="btn btn-danger btn-sm">Gen Watermark</a>
		<a href="/admin/gensitemap" class="btn btn-primary btn-sm">Gen Sitemap</a>
		<a href="/admin/crawler2" class="btn btn-primary btn-sm">Steal novel</a>
		<a href="/admin/gdriveimage" class="btn btn-primary btn-sm">Google drive</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Generate Thumbnail Avatar Images</h3>
				<p>Sẽ mất chút thời gian quét toàn bộ dữ liệu. Có thông báo thành công sau khi kết thúc quá trình.</p>
			</div>
			<div class="box-body">
				@if(count($data) > 0)
					<p>Có <strong>{{ count($data) }} ảnh avatar được tạo thumbnail</strong></p>
					<ul>
						@foreach($data as $value)
						<li>{{ $value }}</li>
						@endforeach
					</ul>
				@else
					<p>No Generate Thumbnail Avatar Images</p>
				@endif
			</div>
		</div>
	</div>
</div>

@stop