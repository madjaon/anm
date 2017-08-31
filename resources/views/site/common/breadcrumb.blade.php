@if($breadcrumb)
<ol class="breadcrumb px-0 py-2" itemscope itemtype="http://schema.org/BreadcrumbList">
  <li class="breadcrumb-item" itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><a href="{{ url('/') }}" title="Trang chủ" itemprop="item"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="1" /></li>
  @foreach($breadcrumb as $key => $value)
    @if($value['link'])
      <li class="breadcrumb-item" itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><a href="{{ $value['link'] }}" title="{{ $value['name'] }}" itemprop="item"><span itemprop="name">{{ $value['name'] }}</span></a><meta itemprop="position" content="{{ ($key + 2) }}" /></li>
    @else
      <li class="breadcrumb-item active" itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><span itemprop="name">{{ $value['name'] }}</span><meta itemprop="position" content="{{ ($key + 2) }}" /></li>
    @endif
  @endforeach
</ol>
@endif