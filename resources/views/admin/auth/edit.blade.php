@extends('admin.layouts.master')

@section('title', 'Sửa tài khoản')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.account.index') }}" class="btn btn-success">Danh sách tài khoản</a>
		<a href="{{ route('admin.account.create') }}" class="btn btn-primary">Thêm tài khoản</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.account.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa tài khoản</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name</label>
						<div class="row">
							<div class="col-sm-6">
								<input name="name" type="text" value="{{ $data->name }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group" style="display: block;">
						<label for="role_id">Quyền hạn</label>
						<div class="row">
							<div class="col-sm-6">
							{!! Form::select('role_id', CommonOption::roleArray(), $data->role_id, array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							@include('admin.common.inputStatusLang', array('isEdit' => true))
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