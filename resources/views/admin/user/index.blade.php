@extends('admin.layouts.master')

@section('title', 'Danh sách tài khoản Users')

@section('content')

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Danh sách tài khoản</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th>Tên</th>
						<th>Username</th>
						<th>Email</th>
						<th>Note</th>
						<th>Post IDs</th>
						<th>Trạng thái</th>
						<th style="width:240px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ $value->username }}</td>
						<td>{{ $value->email }}</td>
						<td style="word-break: keep-all; width:200px;">{{ $value->note }}</td>
						<td>{{ $value->post_ids }}</td>
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td>
							@if(Auth::guard('admin')->user()->role_id == ADMIN)
								<a href="{{ route('admin.user.password', $value->id) }}" class="btn btn-success">Đổi mật khẩu</a>
								<a href="{{ route('admin.user.edit', $value->id) }}" class="btn btn-primary">Sửa</a>
								<form method="POST" action="{{ route('admin.user.destroy', $value->id) }}" style="display: inline-block;">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
								</form>
							@endif
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		{{ $data->links() }}
	</div>
</div>

@include('admin.user.script')

@stop