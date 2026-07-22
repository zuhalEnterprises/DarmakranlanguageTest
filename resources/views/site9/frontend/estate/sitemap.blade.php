<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($estates as $value)
    <url>
        <loc>{{env('APP_URL')}}{{$value->url()}}</loc>
    </url>
    @endforeach
</urlset>
