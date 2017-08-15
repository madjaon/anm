@extends('admin.layouts.master')

@section('title', 'Danh sách tài khoản')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.account.create') }}" class="btn btn-primary">Thêm tài khoản</a>
	</div>
</div>

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
						<th>Email</th>
						<th>Quyền hạn</th>
						<th>Trạng thái</th>
						<th style="width:240px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ $value->email }}</td>
						<td>{{ CommonOption::getRole($value->role_id) }}</td>
						<td><a id="status_{{ $value->id }}" onclick="updateStatus({{ $value->id }}, 'status')" style="cursor: pointer;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
						<td>
							@if(Auth::guard('admin')->user()->id == 1)
								<a href="{{ route('admin.account.password', $value->id) }}" class="btn btn-success">Đổi mật khẩu</a>
								<a href="{{ route('admin.account.edit', $value->id) }}" class="btn btn-primary">Sửa</a>
								@if(Auth::guard('admin')->user()->id == 1 && $value->id != Auth::guard('admin')->user()->id)
								<form method="POST" action="{{ route('admin.account.destroy', $value->id) }}" style="display: inline-block;">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
								</form>
								@endif
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

@include('admin.auth.script')

@stop