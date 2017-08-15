@extends('admin.layouts.master')

@section('title', 'Generate Watermark Images')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
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
				<h3 class="box-title">Generate Watermark Images</h3>
				<p>Sẽ mất chút thời gian quét toàn bộ dữ liệu. Có thông báo thành công sau khi kết thúc quá trình.</p>
			</div>
			<div class="box-body">
				@if(isset($data->total) && $data->total > 0)
					<p>Có <strong>{{ $data->total }} ảnh được tạo watermark</strong></p>
				@else
					<p>Không có ảnh nào được tạo watermark</p>
				@endif
				<form action="{{ url('admin/genwatermarkAction') }}" method="POST">
					{!! csrf_field() !!}
					<div class="form-group">
						<label>Thư mục ảnh</label>
						<p>Nếu để trống không nhập: mặc định là thư mục images/</p>
						<p>Nếu nhập: theo mẫu: images/ten-thu-muc/</p>
						<p>Hoặc nhập theo mẫu: images/ten-thu-muc/ten-thu-muc-con/</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="dir" type="text" value="{{ old('dir') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Mã ảnh</label>
						<p>Mã base64 encode: <a href="https://www.base64-image.de/" target="_blank" rel="nofollow">click để tới trang tạo mã</a></p>
						<p>Cỡ ảnh watermark đang là: 176x28</p>
						<p>Đang để chỉ tạo watermark với ảnh cỡ: width >= {{ WATERMARK_MINWIDTH }}, height > {{ WATERMARK_MINHEIGHT }}</p>
						<p>Ảnh watermark nếu để trống: <img src="{{ WATERMARK_BASE64 }}" alt="" width="176" height="28"></p>
						<div class="row">
							<div class="col-sm-8">
								<input name="code" type="text" value="{{ old('code') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Vị trí</label>
						<p>Mặc định (để trống): bottom-right</p>
						<p>// top-left
							// top
							// top-right
							// left
							// center
							// right
							// bottom-left
							// bottom
							// bottom-right</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="position" type="text" value="{{ old('position') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Tạo Watermark cho ảnh THUMBNAILs?</label>
						<p>Nếu ảnh thumbnails quá nhỏ thì không nên tạo watermark.</p>
						<p>Đang để chỉ tạo watermark với ảnh cỡ: width >= {{ WATERMARK_MINWIDTH }}, height > {{ WATERMARK_MINHEIGHT }}</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('status', CommonOption::statusArray(), old('status'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								<input type="submit" class="btn btn-primary" value="Lưu lại" />
								<input type="reset" class="btn btn-default" value="Nhập lại" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@stop