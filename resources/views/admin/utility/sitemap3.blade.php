<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(!empty($postEps))
        @foreach($postEps as $value)
            <?php 
                $postSlug = CommonQuery::getFieldById('posts', $value->post_id, 'slug');
            ?>
            <url>
                <loc>{{ url($postSlug . '/' . $value->slug) }}</loc>
                <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endif
</urlset>