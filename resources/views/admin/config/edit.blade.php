@extends('admin.layouts.master')

@section('title', 'Config')

@section('content')

<div class="row">
	<div class="col-xs-12">
			<div class="box">
			<form method="POST" action="{{ route('admin.config.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Config Page</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group" style="display: block;">
								<label>Code</label>
								<p>Google analytics, facebook code... (nằm trong thẻ head)</p>
								<div class="row">
									<div class="col-sm-12">
										<textarea name="code" class="form-control" rows="5">{{ $data->code }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-group" style="display: block;">
								<label>Facebook App ID</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="facebook_app_id" type="text" value="{{ $data->facebook_app_id }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Credit</label>
								<p>Text cuối trang</p>
								<div class="row">
									<div class="col-sm-12">
										<textarea name="credit" class="form-control textarea" rows="5">{{ $data->credit }}</textarea>
									</div>
								</div>
							</div>
							@include('admin.common.inputMeta', array('isEdit' => true))
						</div>
						<div class="col-sm-4">
							<div class="box-footer">
								<input type="submit" class="btn btn-primary" value="Lưu lại" />
								<input type="reset" class="btn btn-default" value="Nhập lại" />
							</div>
							<div class="form-group" style="display: block;">
								<label>Top Post</label>
								<p>Nhập ID post muốn đưa lên danh sách top. Mỗi ID cách nhau bởi dấu phẩy</p>
								<div class="row">
									<div class="col-sm-12">
										<p style="display: none;">
											<label>Top ngày</label>
											<input name="top_day" type="text" value="{{ $data->top_day }}" class="form-control">
										</p>
										<p style="display: none;">
											<label>Top tuần</label>
											<input name="top_week" type="text" value="{{ $data->top_week }}" class="form-control">
										</p>
										<p style="display: none;">
											<label>Top tháng</label>
											<input name="top_month" type="text" value="{{ $data->top_month }}" class="form-control">
										</p>
										<p style="display: none;">
											<label>Top quý</label>
											<input name="top_quarter" type="text" value="{{ $data->top_quarter }}" class="form-control">
										</p>
										<p style="display: none;">
											<label>Top năm</label>
											<input name="top_year" type="text" value="{{ $data->top_year }}" class="form-control">
										</p>
										<p style="display: none;">
											<label>Top tổng</label>
											<input name="top_total" type="text" value="{{ $data->top_total }}" class="form-control">
										</p>
										<p style="display: none;">
											<label>Top mùa</label>
											<input name="top_season" type="text" value="{{ $data->top_season }}" class="form-control">
										</p>
										<p>
											<label>Top trending (xu hướng)</label>
											<input name="top_trending" type="text" value="{{ $data->top_trending }}" class="form-control">
										</p>
									</div>
								</div>
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