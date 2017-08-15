@extends('admin.layouts.master')

@section('title', 'post tags')

@section('content')

@include('admin.posttag.search')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.posttag.create') }}" class="btn btn-primary btn-sm">Thêm post tags</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">post tags</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th>Name</th>
						<th>URL</th>
						<th>Status</th>
						<th style="width:240px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ CommonUrl::getUrlPostTag($value->slug, 1) }}</td>
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td>
							<a href="{{ CommonUrl::getUrlPostTag($value->slug) }}" class="btn btn-success btn-sm" target="_blank">Xem</a>
							<a href="{{ route('admin.posttag.edit', $value->id) }}" class="btn btn-primary btn-sm">Sửa</a>
							<form method="POST" action="{{ route('admin.posttag.destroy', $value->id) }}" style="display: inline-block;">
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

@include('admin.posttag.script')

@stop