@extends('admin.layouts.master')

@section('title', 'Sửa post chap')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.postep.index') }}?post_id={{ $request->post_id }}&post_name={{ $request->post_name }}&post_slug={{ $request->post_slug }}" class="btn btn-success btn-sm">Danh sách post chaps</a>
		<a href="{{ route('admin.postep.create') }}?post_id={{ $request->post_id }}&post_name={{ $request->post_name }}&post_slug={{ $request->post_slug }}" class="btn btn-primary btn-sm">Thêm post chap</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.postep.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa post chap</h3>
					<p></p>
					<p style="font-weight: bold;">ID post: {{ $request->post_id }} - <span style="color: red; font-weight: bold;">{{ $request->post_name }}</span> - <a href="{{ CommonUrl::getUrl($request->post_slug) }}" target="_blank">Xem</a> | <a href="{{ route('admin.post.edit', $request->post_id) }}">Sửa</a></p>
					<input type="hidden" name="post_id" value="{{ $request->post_id }}">
					<input type="hidden" name="post_name" value="{{ $request->post_name }}">
					<input type="hidden" name="post_slug" value="{{ $request->post_slug }}">
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label>Name <span style="color: red;">(*)</span></label>
								<div class="row">
									<div class="col-sm-12">
										<input name="name" type="text" value="{{ $data->name }}" class="form-control" onkeyup="convert_to_slug(this.value);">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Slug <span style="color: red;">(*)</span></label>
								<div class="row">
									<div class="col-sm-12">
										<input name="slug" type="text" value="{{ $data->slug }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group" style="display: none;">
								<label>Ngày đăng</label>
								<div class="row">
									<div class="col-sm-6">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input name="start_date" type="text" value="{{ CommonMethod::datetimeToArray($data->start_date, 1) }}" class="form-control pull-right datepicker">
						                </div>
									</div>
									<div class="col-sm-6">
										<div class="bootstrap-timepicker">
											<div class="input-group">
												<input name="start_time" type="text" value="{{ CommonMethod::datetimeToArray($data->start_date, 2) }}" class="form-control timepicker">
												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>	
										</div>
									</div>
								</div>
							</div>
							@include('admin.common.inputStatusLang', array('isEdit' => true))
							<!-- include('admin.common.inputContent', array('isEdit' => true)) -->
							@include('admin.common.inputMeta', array('isEdit' => true))
						</div>
						<div class="col-sm-4">
							<div class="box-footer">
								<input type="submit" class="btn btn-primary" value="Lưu lại" />
								<input type="reset" class="btn btn-default" value="Nhập lại" />
							</div>
							<div class="form-group">
								<label>Số tập hiện tại <span style="color: red;">(*)</span></label>
								<div class="row">
									<div class="col-sm-12">
										<input name="epchap" type="text" value="{{ $data->epchap }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 1 ({{ SERVER1 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server1" type="text" value="{{ $data->server1 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 2 ({{ SERVER2 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server2" type="text" value="{{ $data->server2 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 3 ({{ SERVER3 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server3" type="text" value="{{ $data->server3 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 4 ({{ SERVER4 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server4" type="text" value="{{ $data->server4 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 5 ({{ SERVER5 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server5" type="text" value="{{ $data->server5 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 6 ({{ SERVER6 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server6" type="text" value="{{ $data->server6 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 7 ({{ SERVER7 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server7" type="text" value="{{ $data->server7 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 8 ({{ SERVER8 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server8" type="text" value="{{ $data->server8 }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Server 9 ({{ SERVER9 }})</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="server9" type="text" value="{{ $data->server9 }}" class="form-control">
									</div>
								</div>
							</div>
							
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

@stop