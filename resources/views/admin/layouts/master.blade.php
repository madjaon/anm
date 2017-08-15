<!DOCTYPE html>
<html>
@include('admin.common.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	@include('admin.common.top')
	<!-- Left side column. contains the logo and sidebar -->
	@include('admin.common.side')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				@yield('title')
				<small>❤ Have a nice day! ❤</small>
			</h1>
			<!-- <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			</ol> -->
		</section>
		<!-- Main content -->
		<section class="content">
			@include('admin.common.errors')
			@yield('content')
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<footer class="main-footer">
		<a href="/admin/clearallstorage">Clear all storage</a> | 
		<strong>Copyright &copy; 2016.</strong>
	</footer>
</div>
<!-- ./wrapper -->
</body>
</html>
