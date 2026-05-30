@php
    $priceProduct = $product ?? $item;
    $priceCurrency = $currency ?? 'ج.م';
    $priceDecimals = $decimals ?? 2;
@endphp

@once
    <style>
        .osx-menu-price{display:inline-grid;gap:2px;align-items:center;line-height:1.15}
        .osx-menu-price-old{display:inline-block;color:currentColor;opacity:.58;text-decoration:line-through;text-decoration-thickness:2px;font-size:.78em;font-weight:800}
        .osx-menu-price-new{display:inline-flex;align-items:center;justify-content:center;gap:4px;color:currentColor;font-weight:1000}
        .osx-menu-price-badge{display:inline-flex;align-items:center;justify-content:center;width:max-content;border-radius:999px;background:#fff0ed;color:#b84d3a;padding:3px 8px;font-size:.68em;font-weight:1000}
    </style>
@endonce

<span class="osx-menu-price">
    @if($priceProduct->hasDiscount())
        <span class="osx-menu-price-old">{{ number_format($priceProduct->price, $priceDecimals) }} {{ $priceCurrency }}</span>
        <span class="osx-menu-price-new">{{ number_format($priceProduct->discount_price, $priceDecimals) }} {{ $priceCurrency }}</span>
        <span class="osx-menu-price-badge">خصم</span>
    @else
        <span class="osx-menu-price-new">{{ number_format($priceProduct->price, $priceDecimals) }} {{ $priceCurrency }}</span>
    @endif
</span>
