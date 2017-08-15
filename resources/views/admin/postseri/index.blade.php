@extends('admin.layouts.master')

@section('title', 'post seri')

@section('content')

@include('admin.postseri.search')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.postseri.create') }}" class="btn btn-primary btn-sm">Thêm post seri</a>
		<a onclick="callupdate();" class="btn btn-success btn-sm" id="loadMsg">Update Position</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">post seri</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th><input type="checkbox" id="checkall" onClick="toggle(this)"></th>
						<th>Name</th>
						<th>URL</th>
						<th>Status</th>
						<th>Position</th>
						<th style="width:240px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<?php 
						$postSeriUrl = CommonUrl::getUrlPostSeri($value->slug, 1);
			        ?>
					<tr>
						<td><input type="checkbox" class="id" name="id[]" value="{{ $value->id }}"></td>
						<td>{{ $value->name }}</td>
						<td>{{ $postSeriUrl }}</td>
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td><input type="text" name="position" value="{{ $value->position }}" size="5" class="onlyNumber" style="text-align: center;"></td>
						<td>
							<a href="{{ $postSeriUrl }}" class="btn btn-success btn-sm" target="_blank">Xem</a>
							<a href="{{ route('admin.postseri.edit', $value->id) }}" class="btn btn-primary btn-sm">Sửa</a>
							<form method="POST" action="{{ route('admin.postseri.destroy', $value->id) }}" style="display: inline-block;">
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

@include('admin.postseri.script')

@stop