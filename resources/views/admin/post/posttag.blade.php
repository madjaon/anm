@if(isset($isCreate))
<?php 
	$dataTag = CommonQuery::getArrayWithStatus('post_tags');
?>
<div class="box-body table-responsive no-padding">
	<h4>Post Tags</h4>
	<p>Tác giả, nhà phát hành</p>
	<div class="overflow-box2">
		@if($dataTag)
			{!! Form::select('tag_id[]', $dataTag, old('tag_id'), array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => 'Select a Tag', 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có tag nào được kích hoạt</i>
		@endif
	</div>
</div>
@elseif(isset($isEdit))
<?php 
	$dataTag = CommonQuery::getArrayWithStatus('post_tags');
	$issetPostTag = CommonPost::issetPostTag($data->id);
?>
<div class="box-body table-responsive no-padding">
	<h4>Post Tags</h4>
	<p>Tác giả, nhà phát hành</p>
	<div class="overflow-box2">
		@if($dataTag)
			{!! Form::select('tag_id[]', $dataTag, $issetPostTag, array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => 'Select a Tag', 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có tag nào được kích hoạt</i>
		@endif
	</div>
</div>
@endif