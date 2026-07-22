<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($estates as $value)
    <url>
        <loc>{{env('APP_URL')}}{{$value->url()}}</loc>
        <lastmod>{{str_replace(' ','T',$value->updated_at)}}+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    @endforeach
</urlset>
