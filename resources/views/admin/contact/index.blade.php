@extends('admin.layouts.master')

@section('title', 'Liên hệ')

@section('content')

@include('admin.contact.search')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a onclick="actionSelected(3);" class="btn btn-danger btn-sm" id="loadMsg3">Xóa mục đã chọn</a>
		<a onclick="actionSelected(1);" class="btn btn-default btn-sm" id="loadMsg1">Đánh dấu đã đọc mục đã chọn</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Liên hệ</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th><input type="checkbox" id="checkall" onClick="toggle(this)"></th>
						<th>Name</th>
						<th>Email</th>
						<th>Tel</th>
						<th>Msg</th>
						<th>Ngày tạo</th>
						<th style="width:100px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<?php 
						if($value->status == INACTIVE) {
							$trStyle = 'style="font-weight: bold !important;"';
						} else {
							$trStyle = '';
						}
					?>
					<tr {!! $trStyle !!}>
						<td><input type="checkbox" class="id" name="id[]" value="{{ $value->id }}"></td>
						<td>{{ $value->name }}</td>
						<td>{{ $value->email }}</td>
						<td>{{ $value->tel }}</td>
						<td style="word-break: keep-all; width:300px;">{{ $value->msg }}</td>
						<td>{{ $value->created_at }}</td>
						<td>
							<form method="POST" action="{{ route('admin.contact.destroy', $value->id) }}" style="display: inline-block;">
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

@include('admin.contact.script')

@stop