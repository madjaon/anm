<?php 
  if(isset($isHome)) {
    $effect = 'animated swing';
  } else {
    $effect = '';
  }
?>
@if(getDevice2() == MOBILE)
<header class="mb-2">
  <div class="container">
    <div class="row">
      <div class="col-8">
        <a href="{!! url('/') !!}" class="d-flex justify-content-start align-items-center py-2 logo" title="Phim On">
          <img src="{!! url('img/logomobile.png') !!}" alt="Truyen On" class="mr-2 animated tada"><span class="pt-2 {!! $effect !!}">Phim On</span>
        </a>  
      </div>
      <div class="col-4">
        <a class="d-flex justify-content-end py-2" onclick="document.getElementById('menumobile').style.display='block'"><i class="fa fa-align-justify menuicon" aria-hidden="true"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <form action="{!! route('site.search') !!}" method="GET" class="form-inline my-3">
          <div class="input-group">
          <input name="s" type="text" value="" class="form-control search-input" placeholder="Tìm kiếm theo tên hoặc hãng phim" id="search" maxlength="255">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
</header>
<div class="menumobile" id="menumobile">
  {!! $menumobile !!}
</div>
@else
<header class="mb-4">
  <nav class="navbar navbar-expand-sm py-1">
    <div class="container">
      <a class="navbar-brand p-0 d-flex align-items-center" href="{!! url('/') !!}" title="Phim On"><img src="{!! url('img/logo.png') !!}" alt="Truyen On" class="mr-2 animated tada"><span class="{!! $effect !!}">Phim On</span></a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="hover" aria-haspopup="true" aria-expanded="false">Thể loại</a>
              {!! $menutypes !!}
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkYear" data-toggle="hover" aria-haspopup="true" aria-expanded="false">Năm</a>
            <div class="dropdown-menu dropdown-mega dropdown-mega-smaller animated fadeInDownNew" aria-labelledby="navbarDropdownMenuLinkYear">
              <div class="row">
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2017) }}">2017</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2016) }}">2016</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2015) }}">2015</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2014) }}">2014</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2013) }}">2013</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2012) }}">2012</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2011) }}">2011</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2010) }}">2010</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2009) }}">2009</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2008) }}">2008</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2007) }}">2007</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2006) }}">2006</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYear(2005) }}">2005</a></div>
                <div class="col-md-3"><a class="dropdown-item" href="{{ CommonUrl::getUrlPostYearBefore(2005)}}">Trước 2005</a></div>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkList" data-toggle="hover" aria-haspopup="true" aria-expanded="false">Danh sách</a>
            <div class="dropdown-menu animated fadeInDownNew" aria-labelledby="navbarDropdownMenuLinkList">
              <a class="dropdown-item" href="{!! CommonUrl::getUrlPostKind('da-hoan-thanh') !!}" title="Danh sách phim đã hoàn thành">Phim đã hoàn thành</a>
              <a class="dropdown-item" href="{!! CommonUrl::getUrlPostKind('con-tiep-tuc') !!}" title="Danh sách phim còn tiếp tục">Phim còn tiếp tục</a>
              <a class="dropdown-item" href="{!! url('hang-phim') !!}" title="Danh sách hãng phim">Hãng phim</a>
            </div>
          </li>
        </ul>
        <form action="{!! route('site.search') !!}" method="GET" class="form-inline my-2 my-lg-0">
          <div class="input-group">
          <input name="s" type="text" value="" class="form-control search-input" placeholder="Tìm kiếm theo tên hoặc hãng phim" id="search" maxlength="255">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </nav>
</header>
@endif
