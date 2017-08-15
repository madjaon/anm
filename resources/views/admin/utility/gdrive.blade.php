@extends('admin.layouts.master')

@section('title', 'Google drive upload image')

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
			<form action="{{ url('admin/gdriveimageAction') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Upload image theo id posts</h3>
					<p>Sẽ mất chút thời gian quét toàn bộ dữ liệu. Có thông báo thành công sau khi kết thúc quá trình.</p>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>ID posts</label>
						<p>Cũng là tên folder ảnh. Nếu nhiều, cách nhau bởi dấu phẩy (2,3,4)</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="post_ids" type="text" value="{{ old('post_ids') }}" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="submit" class="btn btn-primary" value="Lưu lại" />
					<input type="reset" class="btn btn-default" value="Nhập lại" />
				</div>
			</form>
		</div>
	</div>
</div>

@stop