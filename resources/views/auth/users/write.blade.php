@extends('auth.layouts.master')

@section('title', 'Thêm Chương')

@section('body')
<form action="{{ url('user/write') }}" method="post" id="reform">
	<div class="row">
		<div class="col">
			<div class="box-style mb-3">
				<div class="d-inline-flex py-2 title">@yield('title')</div>
		  	</div>
		  	@include('auth.common.errors')
		  	<p>Tên truyện: {{ $data->name }}</p>
			<input name="_token" type="hidden" value="{{ csrf_token() }}">
			<input name="x" type="hidden" value="{{ $data->id }}">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="name">Chương {{ $data->currentep }}</label>
						<input name="name" type="text" class="form-control" id="name" maxlength="255">
						<small class="text-muted">Nhập tiêu đề chương hoặc Có thể bỏ trống.</small>
					</div>
				</div>
				<div class="col-sm-6 d-flex align-items-center">
					<label class="custom-control custom-checkbox d-flex align-items-center">
						<input type="checkbox" class="custom-control-input" name="kind" value="1">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">Đánh dấu chương cuối.</span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label for="description">Nội Dung <span style="color: red;">(*)</span></label>
				<textarea name="description" class="form-control" id="description" maxlength="10000" rows="12"></textarea>
				<small class="text-muted">Bắt buộc phải nhập nội dung truyện.</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<!-- <button type="submit" class="btn btn-primary mr-1" id="submit"><i class="fa fa-btn fa-save mr-1"></i>Lưu và Tiếp Tục</button> -->
				<button class="btn btn-primary g-recaptcha" data-sitekey="{{ RECAPTCHASITEKEY }}" data-callback="onSubmit"><i class="fa fa-btn fa-save mr-1"></i>Lưu và Tiếp Tục</button>
				<button type="reset" class="btn btn-default"><i class="fa fa-btn fa-refresh mr-1"></i>Nhập lại</button>
				<a href="{{ url('user') }}" title="Tài khoản" class="btn btn-secondary"><i class="fa fa-reply mr-1" aria-hidden="true"></i>Quay lại</a>
			</div>
		</div>
	</div>
</form>
@endsection
