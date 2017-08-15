@if(isset($isCreate))
<h3>META</h3>
<div class="form-group">
	<label for="meta_title">Meta title</label>
	<div class="row">
		<div class="col-sm-12">
			<input name="meta_title" type="text" value="{{ old('meta_title') }}" class="form-control">
		</div>
	</div>
</div>
<div class="form-group">
	<label for="meta_keyword">Meta keyword</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="meta_keyword" class="form-control" rows="5">{{ old('meta_keyword') }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="meta_description">Meta description</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="meta_description" class="form-control" rows="5">{{ old('meta_description') }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="meta_image">Meta image</label>
	<p>Ảnh chia sẻ trên facebook: cỡ lớn: 1200 x 630, cỡ nhỏ: 600 x 315, tối thiếu: 200 x 200</p>
	<p>Định dạng jpg, jpeg, png. Tên thư mục & ảnh phải là không dấu, không chứa dấu cách + kí tự đặc biệt. Dung lượng ảnh nhẹ (< 1mb)</p>
	<div class="row">
		<div class="col-sm-9">
			<input name="meta_image" type="text" value="{{ old('meta_image') }}" class="form-control" readonly id="url_abs1" onchange="GetFilenameFromPath2('url_abs1');">
		</div>
		<div class="col-sm-3">
            <a href="/adminlte/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs1&akey={{ AKEY }}" class="iframe-btn" type="button"><input class="btn btn-primary" type="button" value="Chọn hình..." /></a>
		</div>
	</div>
</div>
@include('admin.common.scriptImage')
@elseif(isset($isEdit))
<h3>META</h3>
<div class="form-group">
	<label for="meta_title">Meta title</label>
	<div class="row">
		<div class="col-sm-12">
			<input name="meta_title" type="text" value="{{ $data->meta_title }}" class="form-control">
		</div>
	</div>
</div>
<div class="form-group">
	<label for="meta_keyword">Meta keyword</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="meta_keyword" class="form-control" rows="5">{{ $data->meta_keyword }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="meta_description">Meta description</label>
	<div class="row">
		<div class="col-sm-12">
			<textarea name="meta_description" class="form-control" rows="5">{{ $data->meta_description }}</textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="meta_image">Meta image</label>
	<p>Ảnh chia sẻ trên facebook: cỡ lớn: 1200 x 630, cỡ nhỏ: 600 x 315, tối thiếu: 200 x 200</p>
	<p>Định dạng jpg, jpeg, png. Tên thư mục & ảnh phải là không dấu, không chứa dấu cách + kí tự đặc biệt. Dung lượng ảnh nhẹ (< 1mb)</p>
	<div class="row">
		<div class="col-sm-9">
			<input name="meta_image" type="text" value="{{ $data->meta_image }}" class="form-control" readonly id="url_abs1" onchange="GetFilenameFromPath2('url_abs1');">
		</div>
		<div class="col-sm-3">
            <a href="/adminlte/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=url_abs1&akey={{ AKEY }}" class="iframe-btn" type="button"><input class="btn btn-primary" type="button" value="Chọn hình..." /></a>
		</div>
	</div>
</div>
@include('admin.common.scriptImage')
@endif