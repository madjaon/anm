@extends('admin.layouts.master')

@section('title', 'Thêm slider')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.slider.index') }}" class="btn btn-success btn-sm">Danh sách slider</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ route('admin.slider.store') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm slider</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="name" type="text" value="{{ old('name') }}" class="form-control" onkeyup="convert_to_slug(this.value);">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="url">Url</label>
						<p>Chú ý: Nhập # nếu không có đường dẫn</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="url" type="text" value="{{ old('url') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="type">Type <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('type', CommonOption::sliderTypeArray(), old('type'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="image">Hình <span style="color: red;">(*)</span></label>
						<p>Định dạng jpg, jpeg, png. Tên thư mục & ảnh phải là không dấu, không chứa dấu cách + kí tự đặc biệt. Dung lượng ảnh nhẹ (< 1mb)</p>
						<p>Kích cỡ:</p>
						<ul>
							<li>Slider đầu trang: {{ SLIDE_HEADER_DIMENSIONS }}</li>
							<!-- <li>Slider cuối trang: {{-- SLIDE_FOOTER_DIMENSIONS --}}</li> -->
						</ul>
						<div class="row">
							<div class="col-sm-6">
								<input name="image" type="text" value="{{ old('image') }}" class="form-control" readonly id="url_abs" onchange="GetFilenameFromPath2('url_abs');">
							</div>
							<div class="col-sm-2">
					            <a href="/adminlte/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs&akey={{ AKEY }}" class="iframe-btn" type="button"><input class="btn btn-primary" type="button" value="Chọn hình..." /></a>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-8">
							@include('admin.common.inputStatusLang', array('isCreate' => true))
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
@include('admin.common.scriptImage')
@stop