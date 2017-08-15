@extends('admin.layouts.master')

@section('title', 'Steal novel')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.post.index') }}" class="btn btn-success btn-sm">Danh sách post</a>
		<a href="{{ route('admin.post.create') }}" class="btn btn-primary btn-sm">Thêm post</a>
		<a href="/admin/genwatermark" class="btn btn-danger btn-sm">Gen Watermark</a>
		<a href="/admin/gensitemap" class="btn btn-primary btn-sm">Gen Sitemap</a>
		<a href="/admin/crawler2" class="btn btn-primary btn-sm">Steal novel</a>
		<a href="/admin/gdriveimage" class="btn btn-primary btn-sm">Google drive</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Truyenfull.vn</a></li>
					<li><a href="#tab2" data-toggle="tab">Steal Chapters</a></li>
					<li><a href="#tab3" data-toggle="tab">Steal Chapters Pattern</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<div class="row">
							<div class="col-sm-6">
								<form action="{{ url('admin/crawler2/truyenfullpost') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-header">
										<h3 class="box-title">Truyenfull.vn</h3>
									</div>
									<div class="box-body">
										<h4>Lấy Danh sách Truyện</h4>
										<div class="form-group">
											<label>Đường dẫn chuyên mục</label>
											<p>Nếu lấy theo link thể loại thì bỏ qua (nhập ID thể loại chính là đủ)</p>
											<div class="row">
												<div class="col-sm-12">
													<input name="url" type="text" value="{{ old('url') }}" class="form-control">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Chuyên mục/thể loại chính</label>
													<div class="row">
														<div class="col-sm-12">
														{!! Form::select('type_main_id', $postTypeArray, old('type_main_id'), array('class' => 'form-control')) !!}
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Số trang (trang cuối)</label>
													<div class="row">
														<div class="col-sm-12">
															<input name="category_page_end" type="text" value="{{ old('category_page_end') }}" class="form-control onlyNumber">
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
							<div class="col-sm-6">
								<form action="{{ url('admin/crawler2/truyenfullchap') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-header">
										<h3 class="box-title">Truyenfull.vn</h3>
									</div>
									<div class="box-body">
										<h4>Lấy Danh sách Chapter</h4>
										<div class="form-group">
											<label>ID posts</label>
											<p>Nếu nhiều, cách nhau bởi dấu phẩy (2,3,4)</p>
											<div class="row">
												<div class="col-sm-12">
													<input name="post_ids" type="text" value="{{ old('post_ids') }}" class="form-control">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>ID post bắt đầu</label>
													<div class="row">
														<div class="col-sm-12">
															<input name="post_id_start" type="text" value="{{ old('post_id_start') }}" class="form-control onlyNumber">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>ID post kết thúc</label>
													<div class="row">
														<div class="col-sm-12">
															<input name="post_id_end" type="text" value="{{ old('post_id_end') }}" class="form-control onlyNumber">
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
						<div class="row">
							<div class="col-sm-12">
								<form action="{{ url('admin/crawler2/truyenfullpostchap') }}" method="POST">
									{!! csrf_field() !!}
									<div class="box-header">
										<h3 class="box-title">Truyenfull.vn</h3>
									</div>
									<div class="box-body">
										<h4>Lấy Truyện + Chap</h4>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Link truyện</label>
													<div class="row">
														<div class="col-sm-12">
															<input name="url" type="text" value="{{ old('url') }}" class="form-control">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Chuyên mục/thể loại chính</label>
													<div class="row">
														<div class="col-sm-12">
														{!! Form::select('type_main_id', $postTypeArray, old('type_main_id'), array('class' => 'form-control')) !!}
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
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab2">
						<form action="{{ url('admin/crawler2/stealchapters') }}" method="POST">
							{!! csrf_field() !!}
							<div class="box-header">
								<h3 class="box-title">Lấy chapters theo links</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Links Chapters</label>
											<p>Nếu nhiều, ngăn cách bởi dấu phẩy</p>
											<div class="row">
												<div class="col-sm-12">
												<textarea name="chap_links" class="form-control" rows="3">{{ old('chap_links') }}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Slugs Chapters</label>
											<p>Slug tương ứng với danh sách links bên trên. Nếu nhiều, ngăn cách bởi dấu phẩy</p>
											<div class="row">
												<div class="col-sm-12">
												<textarea name="chap_slugs" class="form-control" rows="3">{{ old('chap_slugs') }}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Domain Nguồn</label>
											<p>ex: vnexpress.net</p>
											<div class="row">
												<div class="col-sm-12">
													<input name="source" type="text" value="{{ old('source') }}" class="form-control">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Mẫu thẻ cần xóa trong nội dung</label>
											<p>Xóa thẻ và nội dung bên trong thẻ. Nếu nhiều, ngăn cách bằng dấu phẩy</p>
											<p>Đã tự động xóa link (thẻ a)</p>
											<div class="row">
												<div class="col-sm-12">
												<textarea name="description_pattern_delete" class="form-control" rows="3">{{ old('description_pattern_delete') }}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Mẫu thẻ chứa tiêu đề</label>
											<div class="row">
												<div class="col-sm-12">
													<input name="title_pattern" type="text" value="{{ old('title_pattern') }}" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Mẫu thẻ chứa nội dung</label>
											<div class="row">
												<div class="col-sm-12">
													<input name="description_pattern" type="text" value="{{ old('description_pattern') }}" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>ID post cần thêm chapters</label>
											<div class="row">
												<div class="col-sm-12">
													<input name="post_id" type="text" value="{{ old('post_id') }}" class="form-control">
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
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab3">
						<form action="{{ url('admin/crawler2/stealchapterspattern') }}" method="POST">
							{!! csrf_field() !!}
							<div class="box-header">
								<h3 class="box-title">Lấy chapters theo links - site mẫu</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Links Chapters</label>
											<p>Nếu nhiều, ngăn cách bởi dấu phẩy</p>
											<div class="row">
												<div class="col-sm-12">
												<textarea name="chap_links" class="form-control" rows="3">{{ old('chap_links') }}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Nguồn</label>
											<div class="row">
												<div class="col-sm-12">
													{!! Form::select('source', $sourceArray, old('source'), array('class' => 'form-control')) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Slugs Chapters</label>
											<p>Slug tương ứng với danh sách links bên trên. Nếu nhiều, ngăn cách bởi dấu phẩy</p>
											<div class="row">
												<div class="col-sm-12">
												<textarea name="chap_slugs" class="form-control" rows="3">{{ old('chap_slugs') }}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>ID post cần thêm chapters</label>
											<div class="row">
												<div class="col-sm-12">
													<input name="post_id" type="text" value="{{ old('post_id') }}" class="form-control">
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
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- nav-tabs-custom -->
		</div>
	</div>
</div>

@stop