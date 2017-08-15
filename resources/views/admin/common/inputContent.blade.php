@if(isset($isCreate))
<div class="form-group">
	<label for="summary">Mô tả ngắn</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="summary" class="form-control" rows="5">{{ old('summary') }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="description">Nội dung</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="description" class="form-control elm1" rows="8">{{ old('description') }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="image">Hình đại diện</label>
	<p>Định dạng jpg, jpeg. Tên thư mục & ảnh phải là không dấu, không chứa dấu cách + kí tự đặc biệt. Dung lượng ảnh nhẹ (< 1mb)<br>Auto crop thumbnail: {{ THUMB_DIMENSIONS }}</p>
	<div class="row">
		<div class="col-sm-9">
			<input name="image" type="text" value="{{ old('image') }}" class="form-control" readonly id="url_abs" onchange="GetFilenameFromPath2('url_abs', 1);">
		</div>
		<div class="col-sm-3">
            <a href="/adminlte/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs&akey={{ AKEY }}" class="iframe-btn" type="button"><input class="btn btn-primary" type="button" value="Chọn hình..." /></a>
		</div>
	</div>
</div>
@include('admin.common.scriptImage')
@elseif(isset($isEdit))
<div class="form-group">
	<label for="summary">Mô tả ngắn</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="summary" class="form-control" rows="5">{{ $data->summary }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="description">Nội dung</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="description" class="form-control elm1" rows="8">{{ $data->description }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="image">Hình đại diện</label>
	<p>Định dạng jpg, jpeg. Tên thư mục & ảnh phải là không dấu, không chứa dấu cách + kí tự đặc biệt. Dung lượng ảnh nhẹ (< 1mb)<br>Auto crop thumbnail: {{ THUMB_DIMENSIONS }}</p>
	<div class="row">
		<div class="col-sm-9">
			<input name="image" type="text" value="{{ $data->image }}" class="form-control" readonly id="url_abs" onchange="GetFilenameFromPath2('url_abs', 1);">
		</div>
		<div class="col-sm-3">
            <a href="/adminlte/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs&akey={{ AKEY }}" class="iframe-btn" type="button"><input class="btn btn-primary" type="button" value="Chọn hình..." /></a>
		</div>
	</div>
</div>
@include('admin.common.scriptImage')
@endif