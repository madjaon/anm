@if(isset($isCreate))
<?php 
	$dataSeri = CommonQuery::getArrayWithStatus('post_series');
?>
<div class="box-body table-responsive no-padding">
	<h4>Post Seri</h4>
	<div class="overflow-box2">
		@if($dataSeri)
			{!! Form::select('seri', $dataSeri, old('seri'), array('class' => 'form-control select2limit', 'multiple' => 'multiple', 'data-placeholder' => 'Select a seri', 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có seri nào được kích hoạt</i>
		@endif
	</div>
</div>
@elseif(isset($isEdit))
<?php 
	$dataSeri = CommonQuery::getArrayWithStatus('post_series');
?>
<div class="box-body table-responsive no-padding">
	<h4>Post Seri</h4>
	<div class="overflow-box2">
		@if($dataSeri)
			{!! Form::select('seri', $dataSeri, $data->seri, array('class' => 'form-control select2limit', 'multiple' => 'multiple', 'data-placeholder' => 'Select a seri', 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có seri nào được kích hoạt</i>
		@endif
	</div>
</div>
@endif