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
    <!-- <url>
        <loc>{{-- CommonUrl::getUrlPostNation('trung-quoc') --}}</loc>
        <lastmod>{{-- date('Y-m-d') --}}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url> -->
    <url>
        <loc>{{ CommonUrl::getUrlPostNation('nhat-ban') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php 
        $years = [1979,1983,1984,1985,1986,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018];
    ?>
    @foreach($years as $value)
        <url>
            <loc>{{ CommonUrl::getUrlPostYear($value) }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @if(!in_array($value, [1983,1985,1987,1988,1989]))
        <url>
            <loc>{{ CommonUrl::getUrlPostSeasonYear('dong', $value) }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endif
        @if(!in_array($value, [1983,1984,1985,1986,1990,1996,2018]))
        <url>
            <loc>{{ CommonUrl::getUrlPostSeasonYear('xuan', $value) }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endif
        @if(!in_array($value, [1979,1983,1984,1985,1996,2018]))
        <url>
            <loc>{{ CommonUrl::getUrlPostSeasonYear('ha', $value) }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endif
        @if(!in_array($value, [1979,1984,1986,1987,1988,1990,1991,1992,1993,1998,2018]))
        <url>
            <loc>{{ CommonUrl::getUrlPostSeasonYear('thu', $value) }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endif
    @endforeach
    <url>
        <loc>{{ url('xem-anime-truoc-nam-2005') }}</loc>
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