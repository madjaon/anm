<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="{{ url('sitemap.xsl') }}"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@if(!empty($sitemaps))
    @foreach($sitemaps as $value)
    <sitemap>
        <loc>{{ $value }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>
    @endforeach
@endif
</sitemapindex>