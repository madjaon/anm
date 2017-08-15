@extends('admin.layouts.master')

@section('title', 'Thêm post type')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.posttype.index') }}" class="btn btn-success btn-sm">Danh sách post type</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ route('admin.posttype.store') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm post type</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
								<input name="name" type="text" value="{{ old('name') }}" class="form-control" onkeyup="convert_to_slug(this.value);">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="slug">Slug <span style="color: red;">(*)</span></label>
						<div class="row">
							<div class="col-sm-8">
								<input name="slug" type="text" value="{{ old('slug') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Patterns</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="patterns" type="text" value="{{ old('patterns') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="parent_id">Mục cha</label>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('parent_id', $postTypes, old('parent_id'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="home">Home</label>
						<p>Hiển thị ra trang chủ hay không?</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('home', CommonOption::statusArray(), old('home'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="type">Type</label>
						<p>Thể loại post? (hiển thị 2 tab ngoài trang chủ)</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('type', CommonOption::statusArray(), old('type'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<div class="row">
							<div class="col-sm-8">
								<label for="display">Display</label>
								<p>Kiểu hiển thị danh sách</p>
								{!! Form::select('display', CommonOption::displayArray(), old('display'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="list_posts">List Posts</label>
						<p>Hiển thị danh sách post trong trang thể loại không?</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('list_posts', CommonOption::statusArray(), old('list_posts'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="limited">Limited</label>
						<p>Số items hiển thị trên trang chủ</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="limited" type="text" value="{{ old('limited') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="sort_by">Sắp xếp</label>
						<p>Kiểu sắp xếp danh sách posts (trang chủ)</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('sort_by', CommonOption::postSortByArray(), old('sort_by'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="grid">Grid or List</label>
						<p>Trang thể loại hiển thị dạng ô lưới (không kích hoạt) hay dạng danh sách (kích hoạt)</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('grid', CommonOption::statusArray(), old('grid'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="color">Color</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="color" type="text" value="{{ old('color') }}" class="form-control">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-8">
							@include('admin.common.inputStatusLang', array('isCreate' => true))
							@include('admin.common.inputContent', array('isCreate' => true))
							@include('admin.common.inputMeta', array('isCreate' => true))
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

@include('admin.posttype.script')

@stop