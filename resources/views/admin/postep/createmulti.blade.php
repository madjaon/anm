@extends('admin.layouts.master')

@section('title', 'Thêm eps')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.postep.index') }}?post_id={{ $request->post_id }}&post_name={{ $request->post_name }}&post_slug={{ $request->post_slug }}" class="btn btn-success btn-sm">Danh sách eps</a>
		<a href="{{ route('admin.postep.create') }}?post_id={{ $request->post_id }}&post_name={{ $request->post_name }}&post_slug={{ $request->post_slug }}" class="btn btn-primary btn-sm">Thêm ep</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ url('admin/postep/createmultiaction') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm eps</h3>
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
								<label>Số tập hiện tại <span style="color: red;">(*)</span></label>
								<p>Tập số mấy? 1,2... (hoặc 1-1,1-2...)</p>
								<p>Cách nhau bởi dấu phẩy</p>
								<div class="row">
									<div class="col-sm-12">
										<input name="epchap" type="text" value="{{ old('epchap') }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Links - Danh sách links phim tương ứng với số tập</label>
								<p>Cách nhau bởi dấu phẩy</p>
								<div class="row">
									<div class="col-sm-12">
										<textarea name="links" class="form-control" rows="5">{{ old('links') }}</textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="box-footer">
								<input type="submit" class="btn btn-primary" value="Lưu lại" />
								<input type="reset" class="btn btn-default" value="Nhập lại" />
							</div>
							<div class="form-group">
								<label>Server</label>
								<p>Server tương ứng với links phim</p>
								<div class="row">
									<div class="col-sm-12">
									{!! Form::select('servernumber', CommonOption::serverArray(), old('servernumber'), array('class' => 'form-control')) !!}
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