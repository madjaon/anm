@if(isset($isCreate))
<div class="form-group">
	<label for="status">Trạng thái</label>
	<div class="row">
		<div class="col-sm-12">
		{!! Form::select('status', CommonOption::statusArray(), old('status'), array('class' =>'form-control')) !!}
		</div>
	</div>
</div>
<div class="form-group" style="display: none;">
	<label for="lang">Ngôn ngữ</label>
	<div class="row">
		<div class="col-sm-12">
		{!! Form::select('lang', CommonOption::langArray(), old('lang'), array('class' =>'form-control')) !!}
		</div>
	</div>
</div>
@elseif(isset($isEdit))
<div class="form-group">
	<label for="status">Trạng thái</label>
	<div class="row">
		<div class="col-sm-12">
		{!! Form::select('status', CommonOption::statusArray(), $data->status, array('class' =>'form-control')) !!}
		</div>
	</div>
</div>
<div class="form-group" style="display: none;">
	<label for="lang">Ngôn ngữ</label>
	<div class="row">
		<div class="col-sm-12">
		{!! Form::select('lang', CommonOption::langArray(), $data->lang, array('class' =>'form-control')) !!}
		</div>
	</div>
</div>
@endif