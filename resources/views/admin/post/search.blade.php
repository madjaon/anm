<div class="row margin-bottom">
	<div class="col-xs-12">
		<form action="{{ route('admin.post.index') }}" method="GET">
			{!! csrf_field() !!}
			<div class="input-group" style="width: 150px; display:inline-block;">
				<label>Từ khóa/ID</label>
				<input name="name" type="text" value="{{ $request->name }}" class="form-control" placeholder="Name/ID">
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Tình trạng</label>
			  	{{ Form::select('kind', array_add(CommonOption::kindPostArray(), '', '-- chọn'), $request->kind, array('class' =>'form-control')) }}
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Loại bài</label>
			  	{{ Form::select('type', array_add(CommonOption::typePostArray(), '', '-- chọn'), $request->type, array('class' =>'form-control')) }}
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Thể loại</label>
			  	{{ Form::select('type_id', array_add(CommonQuery::getArrayWithStatus('post_types'), '', '-- chọn'), $request->type_id, array('class' =>'form-control')) }}
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Năm</label>
			  	{{ Form::select('year', array_add(CommonOption::yearArray(), '', '-- chọn'), $request->year, array('class' =>'form-control')) }}
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Mùa</label>
			  	{{ Form::select('season', array_add(CommonOption::seasonArray(), '', '-- chọn'), $request->season, array('class' =>'form-control')) }}
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Quốc gia</label>
			  	{{ Form::select('nation', array_add(CommonOption::nationArray(), '', '-- chọn'), $request->nation, array('class' =>'form-control')) }}
			</div>
			<!-- <div class="input-group" style="width: 90px; display:inline-block;">
				<label>Seri</label>
			  	{{-- Form::select('seri', array(''=>'-- chọn',0=>'Chưa có seri'), $request->seri, array('class' =>'form-control')) --}}
			</div> -->
			<!-- <div class="input-group" style="width: 90px; display:inline-block;">
				<label>Nguồn</label>
			  	{{-- Form::select('source', array_add(CommonQuery::getArrayField('posts', 'source'), '', '-- chọn'), $request->source, array('class' =>'form-control')) --}}
			</div> -->
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Trạng thái</label>
			  	{{ Form::select('status', array_add(CommonOption::statusArray(), '', '-- chọn'), $request->status, array('class' =>'form-control')) }}
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Từ ngày</label>
				<input name="start_date" type="text" value="{{ $request->start_date }}" class="form-control pull-right datepicker" placeholder="Từ ngày">
			</div>
			<div class="input-group" style="width: 90px; display:inline-block;">
				<label>Đến ngày</label>
				<input name="end_date" type="text" value="{{ $request->end_date }}" class="form-control pull-right datepicker" placeholder="Đến ngày">
			</div>
			<div class="input-group" style="display: inline-block; vertical-align: bottom; margin-top: 15px;">
				<input type="submit" class="btn btn-primary" value="Search" />
			</div>
		</form>
	</div>
</div>