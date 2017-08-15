<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(!empty($posts))
        @foreach($posts as $value)
        <url>
            <loc>{{ url($value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endforeach
    @endif
</urlset>