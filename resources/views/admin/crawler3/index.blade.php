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
					<li><a href="#tab2" data-toggle="tab">Google Drive Link</a></li>
					<li><a href="#tab3" data-toggle="tab">Extra</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<div class="row">
							<div class="col-sm-6">
								<form action="{{ url('admin/crawler3/steallinkvideo') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-body">
										<div class="form-group">
											<label>Links - Danh sách links nguồn</label>
											<p>Mỗi dòng 1 link</p>
											<div class="row">
												<div class="col-sm-12">
													<textarea name="links" class="form-control nowrap" rows="5">{{ old('links') }}</textarea>
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
						<div class="row">
							<div class="col-sm-12">
								<label>Danh sách dạng link hỗ trợ lấy</label>
								@foreach($linksource as $value)
								<p>{{ $value }}</p>
								@endforeach
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab2">
						<div class="row">
							<div class="col-sm-6">
								<form action="{{ url('admin/crawler3/steallinkvideo3') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-body">
										<div class="form-group">
											<label>Items</label>
											<div class="row">
												<div class="col-sm-12">
													<textarea name="items" class="form-control nowrap" rows="5">{{ old('items') }}</textarea>
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
								<ol>
									<li>Lấy folderId từ link google drive (dạng link: https://drive.google.com/drive/folders/[folderId]) - thư mục chứa phim trên google drive</li>
									<li>Truy cập: https://developers.google.com/drive/v2/reference/children/list#try-it</li>
									<li>Ô orderBy nhập vào: title</li>
									<li>Click Show standard parameters</li>
									<li>Ô fields nhập vào: items</li>
									<li>Click Hide standard parameters</li>
									<li>Ô folderId nhập vào folderId (lấy từ link gdrive ở bước 1.)</li>
									<li>Click nút Excute</li>
									<li>Nếu kết quả phía dưới ra mã 200 thì thành công. Copy toàn bộ nội dung bên dưới (CTRL + A, CTRL + C)</li>
									<li>Trở lại admin, dán nội dung vào ô Items</li>
									<li>Click Lưu lại để lấy links (danh sách links này theo thứ tự sắp xếp theo tên file, giống trong google drive)</li>
								</ol>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab3">
						@if(app()->environment('local'))
						<div class="row">
							<div class="col-sm-6">
								<strong>Lấy ảnh theo đường dẫn animelists</strong>
								<form action="{{ url('admin/crawler3/stealimages') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-body">
										<div class="form-group">
											<label>Links - Danh sách đường dẫn</label>
											<p>Mỗi dòng 1 link</p>
											<div class="row">
												<div class="col-sm-12">
													<textarea name="links" class="form-control nowrap" rows="5">{{ old('links') }}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Tên folder chứa ảnh</label>
											<p>Không dấu, không ký tự đặc biệt</p>
											<div class="row">
												<div class="col-sm-12">
													<input type="text" name="folder" class="form-control" value="{{ old('folder') }}">
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
						@else
						<p>comming soon...</p>
						@endif
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
		$("textarea").val("");
	})
</script>

@stop