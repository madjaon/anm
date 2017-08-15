@extends('admin.layouts.master')

@section('title', 'Sửa menu')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.menu.index') }}" class="btn btn-success btn-sm">Danh sách menu</a>
		<a href="{{ route('admin.menu.create') }}" class="btn btn-primary btn-sm">Thêm menu</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.menu.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa menu</h3>
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
						<label for="url">URL <span style="color: red;">(*)</span></label>
						<p>Chú ý: Nhập # nếu không có đường dẫn</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="url" type="text" value="{{ $data->url }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="type">Loại menu</label>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('type', $optionMenuType, $data->type, array('class' =>'form-control', 'onchange' => 'updateParentIdSelectBox()')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">  <!-- style="display: none;" -->
						<label for="parent_id">Menu cha</label>
						<div class="row">
							{{ Form::hidden('parentId', $data->parent_id) }}
							<div class="col-sm-8" id="ParentIdSelectBox">
							{!! Form::select('parent_id', $optionMenus, $data->parent_id, array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="icon">ICON</label>
						<p>
							Định dạng: {{ '<i class="fa fa-coffee" aria-hidden="true"></i>' }}<br>
							<a href="http://fontawesome.io/icons/" target="_blank">Font Awesome 4.6.3 Icons page</a>
						</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="icon" type="text" value="{{ $data->icon }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="image">ICON Image</label>
						<p>Định dạng jpg, jpeg, png. Tên thư mục & ảnh phải là tiếng việt không dấu, không chứa dấu cách + kí tự đặc biệt. Dung lượng ảnh nhẹ (< 1mb)<br>Kích cỡ: phù hợp với từng mục</p>
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
@include('admin.menu.script')
@stop