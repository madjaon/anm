<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="{{ route('admin.post.index') }}"><i class="fa fa-gamepad"></i> <span>Danh sách phim</span></a></li>
            <li><a href="{{ route('admin.post.create') }}"><i class="fa fa-plus"></i> <span>Thêm phim</span></a></li>
            <li><a href="{{ route('admin.posttype.index') }}"><i class="fa fa-list"></i> <span>Thể loại</span></a></li>
            <li><a href="{{ route('admin.postseri.index') }}"><i class="fa fa-list"></i> <span>Seri phim</span></a></li>
            <li><a href="{{ route('admin.posttag.index') }}"><i class="fa fa-tags"></i> <span>Hãng phim</span></a></li>
            <li><a href="{{ route('admin.page.index') }}"><i class="fa fa-file-text-o"></i> <span>Pages</span></a></li>
            <li><a href="{{ route('admin.slider.index') }}"><i class="fa fa-list"></i> <span>Slider</span></a></li>
            @if(Auth::guard('admin')->user()->role_id == ADMIN)
            <li><a href="{{ route('admin.ad.index') }}"><i class="fa fa-picture-o"></i> <span>Quảng cáo</span></a></li>
            <li><a href="{{ route('admin.contact.index') }}"><i class="fa fa-phone"></i> <span>Liên hệ</span><small class="label pull-right bg-yellow">{{ CommonQuery::contactUnRead() }}</small></a></li>
            <li><a href="{{ route('admin.user.index') }}"><i class="fa fa-user"></i> <span>Người dùng</span></a></li>
            <!-- <li><a href="{{-- route('admin.crawler2.index') --}}"><i class="fa fa-bug"></i> <span>Crawler2</span></a></li> -->
            @endif
            <li class="header">CONFIG</li>
            <!-- <li><a href="{{-- route('admin.menu.index') --}}"><i class="fa fa-navicon"></i> <span>Quản lý menu</span></a></li> -->
            @if(Auth::guard('admin')->user()->role_id == ADMIN)
            <li><a href="{{ route('admin.config.edit', 1) }}"><i class="fa fa-cogs"></i> <span>Cài đặt chung</span></a></li>
            <li><a href="{{ route('admin.account.index') }}"><i class="fa fa-users"></i> <span>Quản lý tài khoản</span></a></li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>