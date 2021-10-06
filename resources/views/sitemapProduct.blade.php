<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        @foreach ($products as $product)
            <url>
                <loc>{{ $product->uri() }}</loc>
                <lastmod>{{ $product->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach

        @foreach ($categories as $category)
            <url>
                <loc>{{ $category->fullHref() }}</loc>
                <lastmod>{{ $category->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.7</priority>
            </url>
        @endforeach

        @foreach ($sections as $section)
            <url>
                <loc>{{ $section->fullHref() }}</loc>
                <lastmod>{{ $section->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    </urlset>
