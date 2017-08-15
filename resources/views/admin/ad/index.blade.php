@extends('admin.layouts.master')

@section('title', 'Quảng cáo')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.ad.create') }}" class="btn btn-primary btn-sm">Thêm Quảng cáo</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Quảng cáo</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th>Name</th>
						<th>Ví trị</th>
						<th>Status</th>
						<th style="width:240px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ CommonOption::getAdPosition($value->position) }}</td>
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td>
							<a href="{{ route('admin.ad.edit', $value->id) }}" class="btn btn-primary btn-sm">Sửa</a>
							<form method="POST" action="{{ route('admin.ad.destroy', $value->id) }}" style="display: inline-block;">
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
		{{ $data->links() }}
	</div>
</div>

@include('admin.ad.script')

@stop