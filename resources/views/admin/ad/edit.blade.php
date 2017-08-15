@extends('admin.layouts.master')

@section('title', 'Sửa Quảng cáo')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.ad.index') }}" class="btn btn-success btn-sm">Danh sách Quảng cáo</a>
		<a href="{{ route('admin.ad.create') }}" class="btn btn-primary btn-sm">Thêm Quảng cáo</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.ad.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa Quảng cáo</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
								<input name="name" type="text" value="{{ $data->name }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="position">Vị trí <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('position', CommonOption::adPositionArray(), $data->position, array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="code">Mã quảng cáo <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
								<textarea name="code" class="form-control" rows="5">{{ $data->code }}</textarea>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="image">Up Ảnh (nếu cần)</label>
						<p>Định dạng jpg, jpeg, png. Tên thư mục & ảnh phải là tiếng việt không dấu, không chứa dấu cách + kí tự đặc biệt. Dung lượng ảnh nhẹ (< 1mb)</p>
						<div class="row">
							<div class="col-sm-6">
								<input name="image" type="text" value="{{ $data->image }}" class="form-control" readonly id="url_abs" onchange="GetFilenameFromPath2('url_abs');">
							</div>
							<div class="col-sm-2">
					            <a href="/adminlte/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs&akey={{ AKEY }}" class="iframe-btn" type="button"><input class="btn btn-primary" type="button" value="Chọn hình..." /></a>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-8">
							@include('admin.common.inputStatusLang', array('isEdit' => true))
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