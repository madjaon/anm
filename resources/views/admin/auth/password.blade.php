@extends('admin.layouts.master')

@section('title', 'Đổi mật khẩu')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.account.index') }}" class="btn btn-success">Danh sách tài khoản</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<form action="{{ route('admin.account.password', $data->id) }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Đổi mật khẩu {{ $data->name }}</h3>
				</div>
				<div class="box-body">
					<input type="hidden" name="id" value="{{ $data->id }}">
					<div class="form-group">
						<label for="password">Mật khẩu mới</label>
						<div class="row">
							<div class="col-sm-6">	       
								<input name="password" type="password" class="form-control" placehoder="Nhập mật khẩu mới!">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password_confirmation">Nhập lại mật khẩu mới</label>
						<div class="row">
							<div class="col-sm-6">	       
							<input name="password_confirmation" type="password" class="form-control" placehoder="Nhập mật khẩu mới!">
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
