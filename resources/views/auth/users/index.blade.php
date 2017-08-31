@extends('auth.layouts.master')

@section('title', 'Tài Khoản')

@section('body')
	<div class="row">
		<div class="col-sm-6">
			<div class="box-style mb-3">
				<div class="d-inline-flex py-2 title">@yield('title')</div>
		  	</div>
			<p>Bút danh: {{ Auth::guard('users')->user()->name }}</p>
			<p>Tên đăng nhập: {{ Auth::guard('users')->user()->username }}</p>
			<p>Email: {{ Auth::guard('users')->user()->email }}</p>
			<form action="{{ url('user/account') }}" method="post" class="my-5" id="reform">
				<h3><i class="fa fa-user mr-1" aria-hidden="true"></i>Sửa thông tin</h3>
				@include('auth.common.errors')
				<input name="_token" type="hidden" value="{{ csrf_token() }}">
				<div class="form-group">
					<input name="name" type="text" value="{{ Auth::guard('users')->user()->name }}" class="form-control" placeholder="Bút Danh" maxlength="255" required>
				</div>
				<div class="form-group">
					<input name="username" type="text" value="{{ Auth::guard('users')->user()->username }}" class="form-control" placeholder="Tên Đăng Nhập" maxlength="255" required>
				</div>
				<div class="form-group">
					<!-- <button type="submit" class="btn btn-primary mr-1" id="submit"><i class="fa fa-btn fa-save mr-1"></i>Lưu lại</button> -->
					<button class="btn btn-primary g-recaptcha" data-sitekey="{{ RECAPTCHASITEKEY }}" data-callback="onSubmit"><i class="fa fa-btn fa-save mr-1"></i>Lưu lại</button>
					<button type="reset" class="btn btn-default"><i class="fa fa-btn fa-refresh mr-1"></i>Nhập lại</button>
				</div>
			</form>
			<p><a href="{{ url(Request::segment(1) . '/password/reset') }}"><i class="fa fa-key mr-1" aria-hidden="true"></i>Đổi mật khẩu</a></p>
		</div>
		<div class="col-sm-6">
			<div class="box-style mb-3">
				<div class="d-inline-flex py-2 title">Truyện của bạn</div>
			</div>
			@if(count($data) > 0)
				<div class="overflow">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="align-middle">Tên truyện</th>
								<th class="align-middle text-center">Mới</th>
								<th class="align-middle text-center">Thêm chương</th>
							</tr>
						</thead>
						<tbody>
						@foreach($data as $key => $value)
							<tr>
								<td class="align-middle">
									<a href="{{ url($value->slug) }}" title="{{ $value->name }}" target="_blank">{{ $value->name }}<i class="fa fa-external-link ml-2" aria-hidden="true"></i></a>
									@if($value->kind == SLUG_POST_KIND_FULL)
									<div class="d-block"><span class="badge badge-success">{{ CommonOption::getKindPost($value->kind) }}</span></div>
									@endif
								</td>
								<td class="align-middle text-center">Chương {{ $dataEp[$key]->epchap }}</td>
								<td class="align-middle text-center" width="150px">
									<a href="{{ url('user/write?x=' . $value->id) }}"><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Thêm chương</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				@else
				<div>Bạn chưa có truyện nào! <a href="{{ url('user/compose') }}" title="Thêm truyện ngay!"><strong>Thêm truyện ngay!</strong></a></div>
			@endif
		</div>
	</div>
@endsection
