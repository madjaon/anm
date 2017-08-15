@extends('admin.layouts.master')

@section('title', 'post type')

@section('content')

@include('admin.posttype.search')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.posttype.create') }}" class="btn btn-primary btn-sm">Thêm post type</a>
		<a onclick="callupdate();" class="btn btn-success btn-sm" id="loadMsg">Update Position</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">post type</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th><input type="checkbox" id="checkall" onClick="toggle(this)"></th>
						<th>Name</th>
						<th>URL</th>
						<!-- <th>Mục cha</th> -->
						<!-- <th>Home</th> -->
						<th>Status</th>
						<th>Position</th>
						<th style="width:240px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<?php 
			            // if($value->parent_id > 0) {
			            //     $parentSlug = CommonQuery::getFieldById('post_types', $value->parent_id, 'slug');
			            //     $postTypeUrl = CommonUrl::getUrl2($parentSlug, $value->slug, 1);
			            // } else {
			            //     $postTypeUrl = CommonUrl::getUrl($value->slug, 1);
			            // }
						$postTypeUrl = CommonUrl::getUrlPostType($value->slug, 1);
			        ?>
					<tr>
						<td><input type="checkbox" class="id" name="id[]" value="{{ $value->id }}"></td>
						<td>{{ $value->name }}</td>
						<td>{{ $postTypeUrl }}</td>
						<!-- <td>{{ CommonQuery::getFieldById('post_types', $value->parent_id, 'name') }}</td> -->
						<!-- <td><a id="home_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'home')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->home) !!}</a></td> -->
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td><input type="text" name="position" value="{{ $value->position }}" size="5" class="onlyNumber" style="text-align: center;"></td>
						<td>
							<a href="{{ $postTypeUrl }}" class="btn btn-success btn-sm" target="_blank">Xem</a>
							<a href="{{ route('admin.posttype.edit', $value->id) }}" class="btn btn-primary btn-sm">Sửa</a>
							<form method="POST" action="{{ route('admin.posttype.destroy', $value->id) }}" style="display: inline-block;">
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

@include('admin.posttype.script')

@stop