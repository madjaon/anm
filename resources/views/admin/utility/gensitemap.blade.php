@extends('admin.layouts.master')

@section('title', 'Generate Sitemap')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="/admin/genwatermark" class="btn btn-danger btn-sm">Gen Watermark</a>
		<a href="/admin/gensitemap" class="btn btn-primary btn-sm">Gen Sitemap</a>
		<a href="/admin/crawler2" class="btn btn-primary btn-sm">Steal novel</a>
		<a href="/admin/gdriveimage" class="btn btn-primary btn-sm">Google drive</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Generate Sitemap</h3>
				<p>Tạo mới sitemap.xml. Sẽ mất chút thời gian quét toàn bộ dữ liệu. Có thông báo thành công sau khi kết thúc quá trình.</p>
			</div>
			<div class="box-body">
				<p><a href="{{ url('sitemap.xml') }}" rel="nofollow" target="_blank">Sitemap link</a></p>
				<form action="{{ url('admin/gensitemapAction') }}" method="POST">
					{!! csrf_field() !!}
					<div class="form-group">
						<label>Tạo file sitemap.xml.gz</label>
						<div class="row">
							<div class="col-sm-8">
							<?php 
								$sitemapType = array(
										'1' => 'Trang chủ/Trang lẻ/Thể loại/Tác giả/Seri/Quốc gia/Tình trạng hoàn thành (sitemap1.xml.gz)',
										'2' => 'Danh sách truyện (sitemap2.xml.gz)',
										'3' => 'Danh sách chương (sitemap3.xml.gz ...)'
									);
							?>
							{!! Form::select('type', $sitemapType, old('type'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								<input type="submit" class="btn btn-primary" value="Lưu lại" />
								<input type="reset" class="btn btn-default" value="Nhập lại" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@stop