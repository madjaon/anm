@extends('auth.layouts.master')

@section('title', 'Thêm Truyện')

@section('body')
<form action="{{ url('user/compose') }}" method="post" id="reform">
	<div class="row">
		<div class="col-sm-6">
			<div class="box-style mb-3">
				<div class="d-inline-flex py-2 title">@yield('title')</div>
		  	</div>
			@include('auth.common.errors')
			<input name="_token" type="hidden" value="{{ csrf_token() }}">
			<div class="form-group">
				<label for="name">Tên Truyện <span style="color: red;">(*)</span></label>
				<input name="name" type="text" class="form-control" id="name" maxlength="255" required>
				<small class="text-muted">Bắt buộc phải nhập tên truyện.</small>
			</div>
			<div class="form-group">
				<label for="name2">Tên Khác</label>
				<input name="name2" type="text" class="form-control" id="name2" maxlength="255">
				<small class="text-muted">Có thể bỏ trống.</small>
			</div>
			<div class="form-group">
				<label for="description">Giới Thiệu Ngắn</label>
				<textarea name="description" class="form-control" id="description" maxlength="1000" rows="6"></textarea>
				<small class="text-muted">Có thể bỏ trống.</small>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="box-style mb-3">
				<div class="d-inline-flex py-2 title">Thể Loại</div>
			</div>
			<?php 
				$dataType = CommonQuery::getAllWithStatus('post_types', ACTIVE, 1);
			?>
			@if($dataType)
				<div class="overflow">
					<ul class="list-unstyled row px-3">
						@foreach($dataType as $key => $value)
							<li class="col-sm-6">
								<label class="custom-control custom-checkbox d-flex align-items-center">
									<input type="checkbox" class="custom-control-input" name="type_id[]" value="{{ $value->id }}">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">{{ $value->name }}</span>
								</label>
							</li>
						@endforeach
					</ul>
				</div>
				<small class="text-muted">Chọn ít nhất 1 thể loại.</small>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<!-- <button type="submit" class="btn btn-primary mr-1" id="submit"><i class="fa fa-btn fa-save mr-1"></i>Lưu và Tiếp Tục</button> -->
				<button class="btn btn-primary g-recaptcha" data-sitekey="{{ RECAPTCHASITEKEY }}" data-callback="onSubmit"><i class="fa fa-btn fa-save mr-1"></i>Lưu và Tiếp Tục</button>
				<button type="reset" class="btn btn-default"><i class="fa fa-btn fa-refresh mr-1"></i>Nhập lại</button>
			</div>
		</div>
	</div>
</form>
@endsection
