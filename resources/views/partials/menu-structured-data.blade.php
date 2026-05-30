@php
    $menuSchemaImage = $seoImage
        ?? ($restaurant->banner_path
            ? asset('storage/'.$restaurant->banner_path)
            : ($restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : asset('osirix-logo.svg')));

    $menuSchema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Restaurant',
        'name' => $restaurant->name,
        'description' => $seoDescription ?? $restaurant->description,
        'url' => $seoCanonical ?? route('menu.show', $menuSetting->slug),
        'image' => $menuSchemaImage,
        'telephone' => $restaurant->phone,
        'address' => $restaurant->address,
        'hasMenu' => [
            '@type' => 'Menu',
            'url' => $seoCanonical ?? route('menu.show', $menuSetting->slug),
            'name' => $restaurant->name.' menu',
        ],
    ]);
@endphp

<script type="application/ld+json">
{!! json_encode($menuSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
