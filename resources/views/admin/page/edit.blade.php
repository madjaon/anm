@extends('admin.layouts.master')

@section('title', 'Sửa Page')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.page.index') }}" class="btn btn-success btn-sm">Danh sách Page</a>
		<a href="{{ route('admin.page.create') }}" class="btn btn-primary btn-sm">Thêm Page</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.page.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa Page</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
								<input name="name" type="text" value="{{ $data->name }}" class="form-control" onkeyup="convert_to_slug(this.value);">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="slug">Slug <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
								<input name="slug" type="text" value="{{ $data->slug }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Patterns</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="patterns" type="text" value="{{ $data->patterns }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							@include('admin.common.inputStatusLang', array('isEdit' => true))
							@include('admin.common.inputContent', array('isEdit' => true))
							@include('admin.common.inputMeta', array('isEdit' => true))
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