@extends('admin.layouts.master')

@section('title', 'Post chap')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.post.index') }}" class="btn btn-success btn-sm">Danh sách post</a>
		<a href="{{ route('admin.postep.index') }}?post_id={{ $request->post_id }}&post_name={{ $request->post_name }}&post_slug={{ $request->post_slug }}" class="btn btn-success btn-sm">Danh sách post chap</a>
		<a href="{{ route('admin.postep.create') }}?post_id={{ $request->post_id }}&post_name={{ $request->post_name }}&post_slug={{ $request->post_slug }}" class="btn btn-primary btn-sm">Thêm post chap</a>
		<a onclick="actionSelected(3);" class="btn btn-danger btn-sm" id="loadMsg3">Xóa mục đã chọn</a>
		<a onclick="actionSelected(1);" class="btn btn-default btn-sm" id="loadMsg1">Đổi Status mục đã chọn</a>
		<a onclick="callupdate();" class="btn btn-success btn-sm" id="loadMsg">Update Position</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Post chap</h3><i> - Total: {{ $data->total() }}</i>
				<p></p>
				<p style="font-weight: bold;">ID post: {{ $request->post_id }} - <span style="color: red; font-weight: bold;">{{ $request->post_name }}</span> - <a href="{{ CommonUrl::getUrl($request->post_slug) }}" target="_blank">Xem</a> | <a href="{{ route('admin.post.edit', $request->post_id) }}">Sửa</a></p>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th><input type="checkbox" id="checkall" onClick="toggle(this)"></th>
						<th>Name</th>
						<th>Slug</th>
						<th>URL</th>
						<!-- <th>Lượt xem</th> -->
						<th>Ngày đăng</th>
						<th>Status</th>
						<th>Position</th>
						<th style="width:200px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<tr>
						<td><input type="checkbox" class="id" name="id[]" value="{{ $value->id }}"></td>
						<td>{{ $value->name }}</td>
						<td>{{ $value->slug }}</td>
						<td>{{ CommonUrl::getUrl2($request->post_slug, $value->slug, 1) }}</td>
						<!-- <td>{{-- CommonMethod::getZero($value->view) --}}</td> -->
						<td>{!! CommonMethod::startDateLabel($value->start_date) !!}</td>
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td><input type="text" name="position" value="{{ $value->position }}" size="5" class="onlyNumber" style="text-align: center;"></td>
						<td>
							<a href="{{ CommonUrl::getUrl2($request->post_slug, $value->slug) }}" class="btn btn-success btn-sm" target="_blank">Xem</a>
							<a href="{{ route('admin.postep.edit', $value->id) }}?post_id={{ $request->post_id }}&post_name={{ $request->post_name }}&post_slug={{ $request->post_slug }}" class="btn btn-primary btn-sm">Sửa</a>
							<form method="POST" action="{{ route('admin.postep.destroy', $value->id) }}" style="display: inline-block;">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<input type="hidden" name="post_id" value="{{ $request->post_id }}">
								<input type="hidden" name="post_name" value="{{ $request->post_name }}">
								<input type="hidden" name="post_slug" value="{{ $request->post_slug }}">
								<button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
							</form>
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		{!! $data->appends($request->except('page'))->render() !!}
	</div>
</div>

@include('admin.postep.script')

@stop