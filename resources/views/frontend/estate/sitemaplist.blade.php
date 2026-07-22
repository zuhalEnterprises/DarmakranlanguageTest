<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @for($i = 0 ; $i <= $count ; $i++)
    <sitemap>
        <loc>{{env('APP_URL')}}/sitemap/estate/{{$i}}</loc>
    </sitemap>
    @endfor
</sitemapindex>
