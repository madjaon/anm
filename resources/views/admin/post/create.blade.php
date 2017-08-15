@extends('admin.layouts.master')

@section('title', 'Thêm post')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.post.index') }}" class="btn btn-success btn-sm">Danh sách post</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ route('admin.post.store') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm post</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label>Name <span style="color: red;">(*)</span></label>
								<div class="row">
									<div class="col-sm-12">
										<input name="name" type="text" value="{{ old('name') }}" class="form-control" onkeyup="convert_to_slug(this.value);">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Slug <span style="color: red;">(*)</span></label>
								<div class="row">
									<div class="col-sm-12">
										<input name="slug" type="text" value="{{ old('slug') }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Tên khác</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="name2" type="text" value="{{ old('name2') }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Loại bài</label>
										<div class="row">
											<div class="col-sm-12">
											{!! Form::select('type', CommonOption::typePostArray(), old('type'), array('class' => 'form-control')) !!}
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Tình trạng hoàn thành</label>
										<div class="row">
											<div class="col-sm-12">
											{!! Form::select('kind', CommonOption::kindPostArray(), old('kind'), array('class' => 'form-control')) !!}
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Quốc gia</label>
										<div class="row">
											<div class="col-sm-12">
											{!! Form::select('nation', CommonOption::nationArray(), old('nation'), array('class' => 'form-control')) !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Năm khởi chiếu</label>
										<div class="row">
											<div class="col-sm-12">
											{!! Form::select('year', CommonOption::yearArray(), old('year'), array('class' => 'form-control')) !!}
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Mùa</label>
										<div class="row">
											<div class="col-sm-12">
											{!! Form::select('season', CommonOption::seasonArray(), old('season'), array('class' => 'form-control')) !!}
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Số tập phim</label>
										<div class="row">
											<div class="col-sm-12">
												<input name="episode" type="text" value="{{ old('episode') }}" class="form-control" placeholder="1/12">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="display: none;">
								<div class="col-sm-8">
									<div class="form-group">
										<label>Ngày đăng</label>
										<div class="row">
											<div class="col-sm-6">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input name="start_date" type="text" value="{{ old('start_date') }}" class="form-control pull-right datepicker">
								                </div>
											</div>
											<div class="col-sm-6">
												<div class="bootstrap-timepicker">
													<div class="input-group">
														<input name="start_time" type="text" class="form-control timepicker">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Patterns</label>
										<div class="row">
											<div class="col-sm-12">
												<input name="patterns" type="text" value="{{ old('patterns') }}" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Nguồn (ex: vnexpress)</label>
										<div class="row">
											<div class="col-sm-12">
												<input name="source" type="text" value="{{ old('source') }}" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="form-group">
										<label>Đường dẫn nguồn</label>
										<div class="row">
											<div class="col-sm-12">
												<input name="source_url" type="text" value="{{ old('source_url') }}" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
							@include('admin.common.inputStatusLang', array('isCreate' => true))
							@include('admin.common.inputContent', array('isCreate' => true))
							@include('admin.common.inputMeta', array('isCreate' => true))
						</div>
						<div class="col-sm-4">
							<div class="box-footer">
								<input type="submit" class="btn btn-primary" value="Lưu lại" />
								<input type="reset" class="btn btn-default" value="Nhập lại" />
							</div>
							@include('admin.post.postseri', array('isCreate' => true))
							@include('admin.post.posttag', array('isCreate' => true))
							@include('admin.post.posttype', array('isCreate' => true))
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