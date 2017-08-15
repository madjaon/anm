@extends('admin.layouts.master')

@section('title', 'Posts')

@section('content')

@include('admin.post.search')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.post.index') }}" class="btn btn-success btn-sm">Danh sách post</a>
		<a href="{{ route('admin.post.create') }}" class="btn btn-primary btn-sm">Thêm post</a>
		<a onclick="actionSelected(3);" class="btn btn-danger btn-sm" id="loadMsg3">Xóa mục đã chọn</a>
		<a onclick="actionSelected(2);" class="btn btn-warning btn-sm" id="loadMsg2">Đổi thể loại mục đã chọn</a>
		<a onclick="actionSelected(1);" class="btn btn-default btn-sm" id="loadMsg1">Đổi Status mục đã chọn</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Posts</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th><input type="checkbox" id="checkall" onClick="toggle(this)"></th>
						<th>ID</th>
						<th>Image</th>
						<th>Name</th>
						<!-- <th>Thể loại chính</th> -->
						<!-- <th>Loại post</th> -->
						<!-- <th>Xem</th> -->
						<!-- <th>Nguồn</th> -->
						<th>Ngày đăng</th>
						<th>Status</th>
						<th style="width:320px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<?php 
						$thumbnail = str_replace('/images/', '/thumbs/', $value->image);
						$thumbnail = str_replace('/thumb/', '/', $thumbnail);
					?>
					<tr>
						<td><input type="checkbox" class="id" name="id[]" value="{{ $value->id }}"></td>
						<td>{{ $value->id }}</td>
						<td><img height="30px" src="{{ $thumbnail }}" /></td>
						<td>{{ $value->name }}</td>
						<!-- <td>{{-- CommonQuery::getFieldById('post_types', $value->type_main_id, 'name') --}}</td> -->
						<!-- <td>{{-- CommonOption::getTypePost($value->type) --}}</td> -->
						<!-- <td>{{-- CommonMethod::getZero($value->view) --}}</td> -->
						<!-- <td><a href="{{-- $value->source_url --}}" target="_blank" rel="nofollow">{{-- $value->source --}}</a></td> -->
						<td>{!! CommonMethod::startDateLabel($value->start_date) !!}</td>
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td>
							<a href="{{ route('admin.postep.index') }}?post_id={{ $value->id }}&post_name={{ $value->name }}&post_slug={{ $value->slug }}" class="btn btn-success btn-sm">Chap</a>
							<a href="{{ route('admin.postep.create') }}?post_id={{ $value->id }}&post_name={{ $value->name }}&post_slug={{ $value->slug }}" class="btn btn-primary btn-sm">Thêm Chap</a>
							<a href="{{ CommonUrl::getUrl($value->slug) }}" class="btn btn-success btn-sm" target="_blank">Xem</a>
							<a href="{{ route('admin.post.edit', $value->id) }}" class="btn btn-primary btn-sm">Sửa</a>
							<form method="POST" action="{{ route('admin.post.destroy', $value->id) }}" style="display: inline-block;">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
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

@include('admin.post.indexposttype')
@include('admin.post.script')

@stop