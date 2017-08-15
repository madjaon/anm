@extends('admin.layouts.master')

@section('title', 'Thêm tài khoản')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.account.index') }}" class="btn btn-success">Danh sách tài khoản</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ route('admin.account.store') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm tài khoản</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name</label>
						<div class="row">
							<div class="col-sm-6">
								<input name="name" type="text" value="{{ old('name') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<div class="row">
							<div class="col-sm-6">
								<input name="email" type="email" value="{{ old('email') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<div class="row">
							<div class="col-sm-6">
								<input name="password" type="password" class="form-control" id="password">
							</div>
						</div>
					</div>
					<div class="form-group" style="display: block;">
						<label for="role_id">Quyền hạn</label>
						<div class="row">
							<div class="col-sm-6">
							{!! Form::select('role_id', CommonOption::roleArray(), old('role_id'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							@include('admin.common.inputStatusLang', array('isCreate' => true))
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