<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>always</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ CommonUrl::getUrlPostKind('da-hoan-thanh') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ CommonUrl::getUrlPostKind('con-tiep-tuc') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('hang-phim') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ CommonUrl::getUrlPostNation('trung-quoc') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ CommonUrl::getUrlPostNation('nhat-ban') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @if(!empty($pages))
        @foreach($pages as $value)
        <url>
            <loc>{{ url($value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if(!empty($postTypes))
        @foreach($postTypes as $value)
        <url>
        	<loc>{{ CommonUrl::getUrlPostType($value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if(!empty($postTags))
        @foreach($postTags as $value)
        <url>
        	<loc>{{ CommonUrl::getUrlPostTag($value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if(!empty($postSeries))
        @foreach($postSeries as $value)
        <url>
            <loc>{{ CommonUrl::getUrlPostSeri($value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endforeach
    @endif
</urlset>