@extends('admin.layouts.master')

@section('title', 'Steal')

@section('content')

<?php 
	if(count($data) > 0) {
		$name = $data->name;
		$source = $data->source;
		$slug_type = $data->slug_type;
		$post_slugs = $data->post_slugs;
		$title_type = $data->title_type;
		$post_titles = $data->post_titles;
		$post_links = $data->post_links;
		$category_link = $data->category_link;
		$category_page_link = $data->category_page_link;
		$category_page_start = $data->category_page_start;
		$category_page_end = $data->category_page_end;
		$category_post_link_pattern = $data->category_post_link_pattern;
		$type_main_id = $data->type_main_id;
		$type = $data->type;
		$image_dir = $data->image_dir;
		$image_pattern = $data->image_pattern;
		$image_check = $data->image_check;
		$title_post_check = $data->title_post_check;
		$title_pattern = $data->title_pattern;
		$description_pattern = $data->description_pattern;
		$description_pattern_delete = $data->description_pattern_delete;
		$element_delete = $data->element_delete;
		$element_delete_positions = $data->element_delete_positions;
		$count_get = $data->count_get;
		$time_get = $data->time_get;
		$start_date = CommonMethod::datetimeToArray($data->start_date, 1);
		$start_time = CommonMethod::datetimeToArray($data->start_date, 2);
		$status = $data->status;
	} else {
		$name = old('name');
		$source = old('source');
		$slug_type = old('slug_type');
		$post_slugs = old('post_slugs');
		$title_type = old('title_type');
		$post_titles = old('post_titles');
		$post_links = old('post_links');
		$category_link = old('category_link');
		$category_page_link = old('category_page_link');
		$category_page_start = old('category_page_start');
		$category_page_end = old('category_page_end');
		$category_post_link_pattern = old('category_post_link_pattern');
		$type_main_id = old('type_main_id');
		$type = old('type');
		$image_dir = old('image_dir');
		$image_pattern = old('image_pattern');
		$image_check = old('image_check');
		$title_post_check = old('title_post_check');
		$title_pattern = old('title_pattern');
		$description_pattern = old('description_pattern');
		$description_pattern_delete = old('description_pattern_delete');
		$element_delete = old('element_delete');
		$element_delete_positions = old('element_delete_positions');
		$count_get = old('count_get');
		$time_get = old('time_get');
		$start_date = old('start_date');
		$start_time = old('start_time');
		$status = old('status');
	}
?>

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.post.index') }}" class="btn btn-success btn-sm">Danh sách post</a>
		<a href="{{ route('admin.post.create') }}" class="btn btn-primary btn-sm">Thêm post</a>
		<a href="{{ route('admin.crawler.index') }}" class="btn btn-warning btn-sm">Thêm mẫu</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Standard Crawler</h3>
			</div>
			<div class="box-body no-padding">
				<!-- Custom Tabs -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-bug"></i> Steal Posts</a></li>
						<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-list-ul"></i> Mẫu lấy tin</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<form>
							{!! csrf_field() !!}
							<input type="hidden" name="id" value="{{ $id }}">
								<div class="box-body no-padding">
									<div class="row">
										<div class="col-sm-8">
											<div class="form-group">
												<label>Kiểu lấy tin</label>
												<div class="row">
													<div class="col-sm-12">
													{!! Form::select('type', CommonOption::typeCrawlerArray(), $type, array('class' => 'form-control', 'onchange' => 'typeCrawler();')) !!}
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Links Posts</label>
												<p>Mỗi dòng 1 link</p>
												<div class="row">
													<div class="col-sm-12">
													<textarea name="post_links" class="form-control crawpost nowrap" rows="3">{{ $post_links }}</textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Slugs Posts</label>
												<p>Slug tương ứng với danh sách link bài viết (phía trên). Mỗi dòng 1 slug</p>
												<p>Chỉ tác dụng khi chọn Kiểu lưu Slug bài viết tương ứng</p>
												<div class="row">
													<div class="col-sm-12">
													<textarea name="post_slugs" class="form-control crawpost nowrap" rows="3">{{ $post_slugs }}</textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Titles Posts</label>
												<p>Title tương ứng với danh sách link bài viết (phía trên). Mỗi dòng 1 title</p>
												<p>Chỉ tác dụng khi chọn Kiểu lưu title bài viết tương ứng</p>
												<div class="row">
													<div class="col-sm-12">
													<textarea name="post_titles" class="form-control crawpost nowrap" rows="3">{{ $post_titles }}</textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Link Category</label>
												<p>Link trang category (hoặc trang 1 nếu có phân trang - k cần page 1 cũng ok)</p>
												<div class="row">
													<div class="col-sm-12">
													<textarea name="category_link" class="form-control crawcategory" rows="3">{{ $category_link }}</textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Link Phân trang Category</label>
												<p>Mẫu link phân trang category (thay số trang bằng [page_number] )</p>
												<p>ex: http://www.blogphongthuy.com/cat/am-duong-tap-luan/xem-tu-vi-tu-vi/menh-so-12-con-giap/tuoi-ty/page/[page_number]</p>
												<div class="row">
													<div class="col-sm-12">
													<textarea name="category_page_link" class="form-control crawcategory" rows="3">{{ $category_page_link }}</textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Số trang Category</label>
												<p>Bắt đầu từ trang 1 nếu không điền <b><small>Link Category</small></b> bên trên. Hoặc bắt đầu từ trang 2 nếu có <b><small>Link Category</small></b> bên trên.</p>
												<p>Kết thúc là số trang category cuối cùng muốn lấy (phải lớn hơn trang Bắt đầu)</p>
												<p>Nếu không nhập (hoặc nhập 0) vào các mục này thì sẽ lấy auto theo logic.</p>
												<div class="row">
													<div class="col-sm-6">
														<label>Bắt đầu</label>
														<input name="category_page_start" type="text" value="{{ $category_page_start }}" class="form-control onlyNumber crawcategory">
													</div>
													<div class="col-sm-6">
														<label>Kết thúc</label>
														<input name="category_page_end" type="text" value="{{ $category_page_end }}" class="form-control onlyNumber crawcategory">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Mẫu thẻ chứa links posts trong trang category</label>
												<div class="row">
													<div class="col-sm-12">
														<input name="category_post_link_pattern" type="text" value="{{ $category_post_link_pattern }}" class="form-control crawcategory">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Thư mục chứa ảnh đại diện post</label>
												<p>Ex: blogphongthuy hoặc blogphongthuy/xyz . Để trống nếu không có</p>
												<div class="row">
													<div class="col-sm-12">
														<input name="image_dir" type="text" value="{{ $image_dir }}" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Mẫu thẻ chứa ảnh đại diện post</label>
												<p>Mẫu thẻ trong trang chuyên mục hoặc trang chi tiết tương ứng với kiểu lấy tin. Để trống nếu không có</p>
												<div class="row">
													<div class="col-sm-12">
														{!! Form::select('image_check', CommonOption::imageCrawlerArray(), $image_check, array('class' => 'form-control')) !!}
														<input name="image_pattern" type="text" value="{{ $image_pattern }}" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Mẫu thẻ chứa tiêu đề post trong trang chi tiết post hoặc trong trang danh sách category.</label>
												<div class="row">
													<div class="col-sm-12">
														{!! Form::select('title_post_check', CommonOption::titleCrawlerArray(), $title_post_check, array('class' => 'form-control')) !!}
														<input name="title_pattern" type="text" value="{{ $title_pattern }}" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Mẫu thẻ chứa nội dung post trong trang chi tiết post</label>
												<div class="row">
													<div class="col-sm-12">
														<input name="description_pattern" type="text" value="{{ $description_pattern }}" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Mẫu thẻ cần xóa trong nội dung post</label>
												<p>Nếu có nhiều mẫu thì ngăn cách bằng dấu phẩy</p>
												<div class="row">
													<div class="col-sm-12">
													<textarea name="description_pattern_delete" class="form-control" rows="3">{{ $description_pattern_delete }}</textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Mẫu thẻ cụ thể cần xóa trong nội dung post</label>
												<p>Xóa nội dung 1 thẻ cụ thể mà không có class hoặc id. Vị trí các thẻ định nghĩa bên dưới. Nếu có nhiều mẫu thì ngăn cách bằng dấu phẩy.</p>
												<p>Ex (xóa thẻ &lt;p&gt; nào đó): p</p>
												<p>hoặc div,h2</p>
												<div class="row">
													<div class="col-sm-12">
														<input name="element_delete" type="text" value="{{ $element_delete }}" class="form-control">
													</div>
												</div>
												<p>Vị trí của mẫu thẻ ở trên. Nếu không có mẫu thẻ ở trên thì để trống. Mỗi mẫu ngăn cách bởi dấu | . Nếu có nhiều vị trí thì ngăn cách bởi dấu phẩy.</p>
												<p>Ex (vị trí thẻ &lt;p&gt; ở trên: 0: thẻ &lt;p&gt; đầu tiên, 1: thẻ &lt;p&gt; thứ 2, -1: thẻ &lt;p&gt; cuối cùng): 0,1,-1</p>
												<p>hoặc 0,1,-1|-1</p>
												<div class="row">
													<div class="col-sm-12">
														<input name="element_delete_positions" type="text" value="{{ $element_delete_positions }}" class="form-control">
													</div>
												</div>
											</div>
											
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Tên mẫu lấy tin @if($id)(id: {{ $id }})@endif</label>
												<div class="row">
													<div class="col-sm-12">
														<input name="name" type="text" value="{{ $name }}" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Domain Nguồn</label>
												<p>ex: vnexpress.net</p>
												<div class="row">
													<div class="col-sm-12">
														<input name="source" type="text" value="{{ $source }}" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Kiểu lưu Slug bài viết</label>
												<div class="row">
													<div class="col-sm-12">
													{!! Form::select('slug_type', CommonOption::slugTypeArray(), $slug_type, array('class' => 'form-control')) !!}
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Kiểu lưu Tiêu đề bài viết</label>
												<div class="row">
													<div class="col-sm-12">
													{!! Form::select('title_type', CommonOption::titleTypeArray(), $title_type, array('class' => 'form-control')) !!}
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Chuyên mục/thể loại chính post</label>
												<div class="row">
													<div class="col-sm-12">
													{!! Form::select('type_main_id', $postTypeArray, $type_main_id, array('class' => 'form-control')) !!}
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Ngày đăng</label>
												<div class="row">
													<div class="col-sm-6">
														<div class="input-group date">
															<div class="input-group-addon">
																<i class="fa fa-calendar"></i>
															</div>
															<input name="start_date" type="text" value="{{ $start_date }}" class="form-control pull-right datepicker">
										                </div>
													</div>
													<div class="col-sm-6">
														<div class="bootstrap-timepicker">
															<div class="input-group">
																<input name="start_time" type="text" value="{{ $start_time }}" class="form-control timepicker">
																<div class="input-group-addon">
																	<i class="fa fa-clock-o"></i>
																</div>
															</div>	
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>Trạng thái</label>
												<div class="row">
													<div class="col-sm-12">
													{!! Form::select('status', CommonOption::statusArray(), $status, array('class' =>'form-control')) !!}
													</div>
												</div>
											</div>

											<div class="box-footer">
												<input type="button" class="btn btn-success stealnow" value="Steal Now" onclick="stealnow()" />
												<input type="button" class="btn btn-primary savenow" value="Lưu lại" onclick="savenow()" />
												<input type="reset" class="btn btn-default" value="Nhập lại" />
											</div>

											<p><i>Nhấn tab Mẫu lấy tin để chọn và tham khảo mẫu có sẵn. Kiểm tra lại đường dẫn lấy tin và các thông tin khác nếu có lỗi xảy ra.</i></p>

										</div>
									</div>
								</div>
								<div class="box-footer">
									<input type="button" class="btn btn-success stealnow" value="Steal Now" onclick="stealnow()" />
									<input type="button" class="btn btn-primary savenow" value="Lưu lại" onclick="savenow()" />
									<input type="reset" class="btn btn-default" value="Nhập lại" />
								</div>
							</form>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
							@if(count($crawlers) > 0)
							<p>Click chọn để sử dụng</p>
							<ul class="row">
								@foreach($crawlers as $key => $value)
								<li class="col-sm-4"><a href="{{ route('admin.crawler.index').'?id='.$value->id }}">{{ $value->name }}</a><p>Số lần: {{ $value->count_get }} / Gần nhất: {{ $value->time_get }}</p></li>
								@endforeach
							</ul>
							@else
							<p>Chưa có mẫu nào</p>
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
</div>

@include('admin.crawler.script')

@stop