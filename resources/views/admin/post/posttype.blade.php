@if(isset($isCreate))
<?php 
	$dataType = CommonQuery::getAllWithStatus('post_types', ACTIVE, 1);
?>
<div class="box-body table-responsive no-padding">
	<h4>Thể loại post <span style="color: red;">(*)</span></h4>
	<div class="overflow-box">
		@if($dataType)
			<input type="hidden" name="type_main_id" value="" required>
			<ul class="todo-list">
				@foreach($dataType as $key => $value)
					<li class="post-type-list">
						<input type="checkbox" name="type_id[]" value="{{ $value->id }}" class="type_id" id="type_id_{{ $value->id }}" onclick="checkPostType({{ $value->id }});" />
						<label for="type_id_{{ $value->id }}">{{ $value->name }}</label>
						<small class="label label-success primary" id="primary_{{ $value->id }}" style="display: none;"><i class="fa fa-key"></i> Primary</small>
						<small class="make_primary" id="make_primary_{{ $value->id }}" onclick="checkKey({{ $value->id }}, 'primary', 'type_main_id');" style="cursor: pointer; display: none;"> Primary</small>
					</li>
				@endforeach
			</ul>
			@include('admin.post.script')
		@else
			<i>Chưa có thể loại nào được kích hoạt</i>
		@endif
	</div>
</div>
@elseif(isset($isEdit))
<?php 
	$dataType = CommonQuery::getAllWithStatus('post_types', ACTIVE, 1);
?>
<div class="box-body table-responsive no-padding">
	<h4>Thể loại post <span style="color: red;">(*)</span></h4>
	<div class="overflow-box">
		@if($dataType)
			<input type="hidden" name="type_main_id" value="{{ $data->type_main_id }}" required>
			<ul class="todo-list">
				@foreach($dataType as $key => $value)
					<li class="post-type-list">
						<input type="checkbox" name="type_id[]" value="{{ $value->id }}" class="type_id" id="type_id_{{ $value->id }}" onclick="checkPostType({{ $value->id }});" <?php echo CommonPost::issetPostTypeChecked($data->id, $value->id); ?> />
						<label for="type_id_{{ $value->id }}">{{ $value->name }}</label>
						<small class="label label-success primary" id="primary_{{ $value->id }}" style="<?php echo CommonPost::issetCheckedDisplay($data->type_main_id, $value->id); ?>"><i class="fa fa-key"></i> Primary</small>
						<small class="make_primary" id="make_primary_{{ $value->id }}" onclick="checkKey({{ $value->id }}, 'primary', 'type_main_id');" style="cursor: pointer; <?php echo CommonPost::issetMakeDisplay($data->id, $data->type_main_id, $value->id); ?>">Primary</small>
					</li>
				@endforeach
			</ul>
			@include('admin.post.script')
		@else
			<i>Chưa có thể loại nào được kích hoạt</i>
		@endif
	</div>
</div>
@endif