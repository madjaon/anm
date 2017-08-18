@extends('admin.layouts.master')

@section('title', 'Steal Link')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.post.index') }}" class="btn btn-success btn-sm">Danh sách post</a>
		<a href="{{ route('admin.post.create') }}" class="btn btn-primary btn-sm">Thêm post</a>
		<a href="/admin/genwatermark" class="btn btn-danger btn-sm">Gen Watermark</a>
		<a href="/admin/gensitemap" class="btn btn-primary btn-sm">Gen Sitemap</a>
		<a href="/admin/crawler3" class="btn btn-primary btn-sm">Steal Link video</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Steal Link video</a></li>
					<li><a href="#tab2" data-toggle="tab">Extra</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<div class="row">
							<div class="col-sm-6">
								<form action="{{ url('admin/crawler3/steallinkvideo') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-body">
										<div class="form-group">
											<label>Linksource - Mẫu Link cần lấy</label>
											<div class="row">
												<div class="col-sm-12">
													{!! Form::select('linksource[]', $linksource, old('linksource'), array('class' =>'form-control', 'multiple' => true)) !!}
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Links - Danh sách links nguồn</label>
											<p>Cách nhau bởi dấu phẩy</p>
											<div class="row">
												<div class="col-sm-12">
													<textarea name="links" class="form-control" rows="5">{{ old('links') }}</textarea>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<input type="submit" class="btn btn-primary" value="Lưu lại" />
													<input type="reset" class="btn btn-default" value="Nhập lại" />
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="col-sm-6">
								<form action="{{ url('admin/crawler3/steallinkvideo2') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-body">
										<div class="form-group">
											<label>Linksource - Mẫu Link cần lấy</label>
											<div class="row">
												<div class="col-sm-12">
													{!! Form::select('linksource[]', $linksource, old('linksource'), array('class' =>'form-control', 'multiple' => true)) !!}
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Source - mã nguồn trang</label>
											<p>Copy mã nguồn chứa link video cần lấy</p>
											<div class="row">
												<div class="col-sm-12">
													<textarea name="source" class="form-control" rows="5">{{ old('source') }}</textarea>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<input type="submit" class="btn btn-primary" value="Lưu lại" />
													<input type="reset" class="btn btn-default" value="Nhập lại" />
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab2">
						<p>comming soon...</p>
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- nav-tabs-custom -->
		</div>
	</div>
</div>

<script>
	$(function () {
		$("select[multiple] option").prop("selected", "selected");
	})
</script>

@stop