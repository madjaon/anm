@extends('admin.layouts.master')

@section('title', 'Sửa tài khoản Users')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.user.index') }}" class="btn btn-success">Danh sách tài khoản Users</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.user.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa tài khoản Users</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Name</label>
						<div class="row">
							<div class="col-sm-6">
								<input name="name" type="text" value="{{ $data->name }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Ghi chú</label>
						<div class="row">
							<div class="col-sm-6">
								<textarea name="note" class="form-control" rows="5">{{ $data->note }}</textarea>
							</div>
						</div>
					</div>
					<div class="form-group" style="display: block;">
						<label>Quyền hạn</label>
						<div class="row">
							<div class="col-sm-6">
							{!! Form::select('role_id', CommonOption::roleUserArray(), $data->role_id, array('class' =>'form-control')) !!}
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