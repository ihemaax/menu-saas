{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ $homeUrl }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach($menus as $menu)
        @php($lastModified = optional($menu->updated_at ?? $menu->restaurant?->updated_at)->toAtomString())
        <url>
            <loc>{{ route('menu.show', $menu->slug) }}</loc>
            @if($lastModified)
                <lastmod>{{ $lastModified }}</lastmod>
            @endif
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
