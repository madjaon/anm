<header class="main-header">
	<!-- Logo -->
	<a href="/" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>A</b>P</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Admin</b>Panel</span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Menu</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="user">
					<a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-bell-o"></i><span class="label label-warning">{{ CommonQuery::contactUnRead() }}</span>Chú ý</a>
				</li>
				<li class="user">
					<a href="/" target="_blank"><i class="fa fa-home"></i>Trang chủ</a>
				</li>
				<li class="user">
					<a href="#"><i class="fa fa-user"></i>{!! Auth::guard('admin')->user()->name !!}</a>
				</li>
				<li class="user">
					<a href="{{ route('admin.auth.logout') }}"><i class="fa fa-power-off"></i>Sign out</a>
				</li>
			</ul>
		</div>
	</nav>
</header>

@include('admin.common.note')
