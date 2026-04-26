<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | المنيو</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { margin: 0; font-family: 'Cairo', sans-serif; background: #f6f1e8; color: #231f1b; }
        .elite-home{max-width:1240px;margin:0 auto;padding:0 10px 40px;}
        .elite-hero-shell{margin-bottom:20px;}
        .elite-hero-card{position:relative;overflow:hidden;border-radius:0 0 30px 30px;background:#fffdf9;border:1px solid #e7ddd1;box-shadow:0 24px 60px rgba(60,52,40,.14);}
        .elite-cover{position:relative;min-height:360px;background:linear-gradient(180deg,rgba(20,20,18,.10),rgba(20,20,18,.30)),url('{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : "https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1600&auto=format&fit=crop" }}') center/cover no-repeat;}
        .elite-cover::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at top right,rgba(255,255,255,.18),transparent 26%),linear-gradient(180deg,rgba(20,20,18,.02),rgba(20,20,18,.18));}
        .elite-cover::after{content:"";position:absolute;inset:auto 0 0 0;height:140px;background:linear-gradient(to top,rgba(12,12,10,.24),transparent);}
        .elite-hero-content{position:relative;margin-top:-74px;padding:0 24px 22px;z-index:3;}
        .elite-identity-card{background:rgba(255,253,249,.96);backdrop-filter:blur(14px);border:1px solid rgba(233,227,216,.95);border-radius:28px;box-shadow:0 24px 60px rgba(60,52,40,.14);padding:18px;}
        .elite-identity-top{display:grid;grid-template-columns:auto minmax(0,1fr);gap:18px;align-items:center;}
        .elite-logo-frame{width:126px;height:126px;border-radius:50%;padding:5px;background:linear-gradient(135deg,#fff 0%,#efe9de 45%,#d8d1c4 100%);box-shadow:0 16px 34px rgba(0,0,0,.10),0 0 0 1px rgba(255,255,255,.9) inset;position:relative;}
        .elite-logo-frame::after{content:"";position:absolute;inset:8px;border-radius:50%;border:1px solid rgba(255,255,255,.85);}
        .elite-logo{width:100%;height:100%;border-radius:50%;background:url('{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : "https://via.placeholder.com/500x500?text=Logo" }}') center/cover no-repeat,#fff;border:4px solid #fff;}
        .elite-brand-kicker{display:inline-flex;align-items:center;gap:8px;padding:7px 12px;border-radius:999px;background:#f4f0e8;color:#746d63;font-size:.75rem;font-weight:900;margin-bottom:10px;letter-spacing:.02em;}
        .elite-brand-kicker .dot{width:7px;height:7px;border-radius:50%;background:currentColor;display:inline-block;}
        .elite-title{margin:0 0 6px;font-size:2rem;line-height:1.15;font-weight:900;letter-spacing:-.02em;}
        .elite-subtitle{margin:0;color:#7b6f63;font-size:.95rem;line-height:1.8;font-weight:800;}
        .elite-meta-row{display:flex;flex-wrap:wrap;gap:10px;padding-top:16px;margin-top:16px;border-top:1px solid #ece5da;}
        .elite-pill{display:inline-flex;align-items:center;gap:8px;min-height:42px;padding:10px 14px;border-radius:999px;background:#f8f5ef;border:1px solid #e7e0d4;color:#5f5a52;font-size:.84rem;font-weight:900;}
        .elite-pill.success{background:#edf8ef;color:#1f7a40;border-color:#d7ebdc;}
        .elite-pill .dot{width:8px;height:8px;border-radius:50%;background:currentColor;display:inline-block;}
        .elite-layout{display:grid;grid-template-columns:300px minmax(0,1fr);gap:18px;align-items:start;}
        .elite-sidebar,.elite-main{display:grid;gap:18px;}
        .elite-card{background:#fffdf9;border:1px solid #e7ddd1;border-radius:24px;box-shadow:0 10px 24px rgba(60,52,40,.05);overflow:hidden;}
        .elite-card-body{padding:18px;}
        .elite-card-title{margin:0 0 14px;font-size:1.02rem;font-weight:900;}
        .elite-info-list{display:grid;gap:10px;}
        .elite-info-item{display:flex;align-items:flex-start;gap:10px;color:#4d4a45;font-size:.92rem;line-height:1.75;font-weight:700;padding:10px;border-radius:14px;background:#faf7f2;border:1px solid #eee5d9;}
        .elite-info-icon{width:34px;height:34px;border-radius:10px;background:#f0ebe2;color:#6f7f5f;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto;font-size:.95rem;}
        .elite-info-text{display:grid;gap:1px;}
        .elite-info-label{font-size:.76rem;color:#8a8176;font-weight:800;}
        .elite-info-value{color:#312d28;}
        .elite-categories{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:12px;padding-bottom:4px;}
        .elite-cat{text-decoration:none;min-width:0;width:auto;text-align:center;display:grid;gap:8px;align-content:start;justify-items:center;}
        .elite-cat-ring{width:100%;max-width:92px;aspect-ratio:1/1;height:auto;border-radius:50%;padding:3px;background:linear-gradient(135deg,#ddd8cf 0%,#f3efe8 100%);margin:0 auto;transition:.2s ease;box-shadow:0 10px 20px rgba(60,52,40,.05);}
        .elite-cat-inner{width:100%;height:100%;border-radius:50%;overflow:hidden;border:3px solid #fff;background:#f2eee7;}
        .elite-cat-inner img{width:100%;height:100%;object-fit:cover;}
        .elite-cat-label{color:#615d55;font-size:.8rem;font-weight:900;line-height:1.35;white-space:normal;word-break:break-word;min-height:2.3em;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
        .elite-cat:hover .elite-cat-ring{background:linear-gradient(135deg,#7d8d6d 0%,#b6c4a6 100%);transform:translateY(-2px);box-shadow:0 14px 24px rgba(111,127,95,.16);}
        .elite-feed{display:grid;gap:18px;}
        .elite-section{background:#fffdf9;border:1px solid #e7ddd1;border-radius:24px;box-shadow:0 10px 24px rgba(60,52,40,.05);overflow:hidden;}
        .elite-section-head{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;padding:18px 18px 10px;}
        .elite-section-title{margin:0;font-size:1.06rem;font-weight:900;}
        .elite-section-count{display:inline-flex;align-items:center;justify-content:center;padding:8px 12px;border-radius:999px;background:#f3efe8;color:#7a7469;font-size:.76rem;font-weight:900;}
        .elite-products{display:grid;gap:14px;padding:0 18px 18px;}
        .elite-product{display:grid;grid-template-columns:180px minmax(0,1fr);gap:14px;align-items:stretch;background:linear-gradient(180deg,#fffdfa 0%,#fcf9f4 100%);border:1px solid #ece5da;border-radius:22px;overflow:hidden;transition:.22s ease;box-shadow:0 10px 24px rgba(60,52,40,.05);}
        .elite-product:hover{transform:translateY(-2px);box-shadow:0 18px 32px rgba(60,52,40,.10);}
        .elite-product-media{position:relative;height:100%;}
        .elite-product-image{width:100%;height:100%;min-height:188px;object-fit:cover;display:block;background:#f1ece4;}
        .elite-product-badge{position:absolute;top:12px;inset-inline-start:12px;background:rgba(25,25,22,.72);color:#fff;border-radius:999px;padding:7px 12px;font-size:.68rem;font-weight:900;backdrop-filter:blur(10px);}
        .elite-product-body{min-width:0;display:flex;flex-direction:column;gap:10px;padding:16px 16px 16px 0;}
        .elite-product-top{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;flex-wrap:wrap;}
        .elite-product-name{margin:0;font-size:1.02rem;font-weight:900;line-height:1.5;letter-spacing:-.01em;}
        .elite-product-category{display:inline-flex;align-items:center;justify-content:center;padding:6px 10px;border-radius:999px;background:#edf2e7;color:#6f7f5f;font-size:.68rem;font-weight:900;white-space:nowrap;}
        .elite-product-desc{margin:0;color:#6f6a61;font-size:.84rem;line-height:1.8;font-weight:700;}
        .elite-product-bottom{margin-top:auto;display:flex;align-items:end;justify-content:space-between;gap:12px;flex-wrap:wrap;}
        .elite-price-label{font-size:.72rem;color:#8a847a;font-weight:800;}
        .elite-price-value{font-size:1.08rem;font-weight:900;}
        .elite-badge{display:inline-flex;align-items:center;justify-content:center;padding:8px 12px;border-radius:999px;background:#f5f0e8;color:#6f7f5f;font-size:.75rem;font-weight:900;}
        .elite-empty{background:#fffdf9;border:1px solid #e7ddd1;border-radius:22px;box-shadow:0 10px 24px rgba(60,52,40,.05);padding:28px 18px;text-align:center;color:#6f6a61;font-weight:800;}
        @media (max-width: 991.98px){.elite-layout{grid-template-columns:1fr}.elite-sidebar{order:2}.elite-main{order:1}}
        @media (max-width: 767.98px){
            .elite-home{padding-bottom:28px}
            .elite-hero-card{border-radius:0 0 22px 22px}
            .elite-cover{min-height:220px}
            .elite-hero-content{margin-top:-34px;padding:0 12px 14px}
            .elite-identity-card{border-radius:20px;padding:14px}
            .elite-identity-top{grid-template-columns:1fr;gap:14px}
            .elite-logo-frame{width:100%;max-width:180px;aspect-ratio:1/1;height:auto;padding:0;margin:0 auto}
            .elite-logo-frame::after{display:none}
            .elite-logo{border-width:0}
            .elite-title{font-size:1.12rem;line-height:1.3;text-align:center}
            .elite-subtitle{font-size:.82rem;line-height:1.7;text-align:center}
            .elite-brand-kicker{display:flex;justify-content:center}
            .elite-meta-row{gap:8px;padding-top:14px;margin-top:14px;justify-content:center}
            .elite-meta-row .elite-pill-phone,
            .elite-meta-row .elite-pill-count{display:none}
            .elite-pill{font-size:.72rem;padding:8px 10px}
            .elite-card-body{padding:14px}
            .elite-categories{grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
            .elite-cat{gap:6px}
            .elite-cat-ring{width:100%;max-width:74px}
            .elite-cat-label{font-size:.74rem}
            .elite-section-head{padding:14px 14px 8px}
            .elite-products{padding:0 14px 14px;gap:12px}
            .elite-product{grid-template-columns:82px minmax(0,1fr);gap:10px;border-radius:16px;padding:8px}
            .elite-product-media{border-radius:12px;overflow:hidden}
            .elite-product-image{min-height:auto;height:82px;border-radius:12px}
            .elite-product-badge{top:auto;bottom:6px;inset-inline-start:6px;padding:5px 8px;font-size:.58rem}
            .elite-product-body{gap:7px;padding:0;justify-content:center}
            .elite-product-name{font-size:.87rem}
            .elite-product-category{font-size:.60rem;padding:5px 7px}
            .elite-product-desc{font-size:.74rem;line-height:1.65;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
            .elite-price-label{font-size:.66rem}
            .elite-price-value{font-size:.88rem}
            .elite-badge{padding:7px 10px;font-size:.70rem;border-radius:12px}
        }
    </style>
</head>
<body>
@php
    $restaurantName = $restaurant->name;
    $restaurantPhone = $restaurant->phone;
    $restaurantAddress = $restaurant->address;
    $restaurantSubtitle = $restaurant->description;
    $allItemsCount = $categories->sum(fn($category) => $category->products->count());
    $sidebarItems = collect([
        $restaurantPhone ? ['label' => 'رقم التواصل', 'value' => $restaurantPhone, 'icon' => '☎', 'link' => 'tel:'.$restaurantPhone] : null,
        $restaurantAddress ? ['label' => 'العنوان', 'value' => $restaurantAddress, 'icon' => '⌂', 'link' => null] : null,
    ])->filter()->values();
@endphp
<div class="elite-home">
    <section class="elite-hero-shell">
        <div class="elite-hero-card">
            <div class="elite-cover"></div>
            <div class="elite-hero-content">
                <div class="elite-identity-card">
                    <div class="elite-identity-top">
                        <div class="elite-logo-frame"><div class="elite-logo"></div></div>
                        <div>
                            <div class="elite-brand-kicker"><span class="dot"></span>المنيو</div>
                            <h1 class="elite-title">{{ $restaurantName }}</h1>
                            @if($restaurantSubtitle)
                                <p class="elite-subtitle">{{ $restaurantSubtitle }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="elite-meta-row">
                        @if($restaurantPhone)<div class="elite-pill elite-pill-phone">{{ $restaurantPhone }}</div>@endif
                        @if($restaurantAddress)<div class="elite-pill">{{ $restaurantAddress }}</div>@endif
                        <div class="elite-pill elite-pill-count">{{ $allItemsCount }} صنف متاح</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="elite-layout" id="menu-area">
        <aside class="elite-sidebar">
            @if($sidebarItems->isNotEmpty())
                <div class="elite-card">
                    <div class="elite-card-body">
                        <h3 class="elite-card-title">معلومات المطعم</h3>
                        <div class="elite-info-list">
                            @foreach($sidebarItems as $sidebarItem)
                                <div class="elite-info-item">
                                    <span class="elite-info-icon">{{ $sidebarItem['icon'] }}</span>
                                    <div class="elite-info-text">
                                        <span class="elite-info-label">{{ $sidebarItem['label'] }}</span>
                                        @if($sidebarItem['link'])
                                            <a href="{{ $sidebarItem['link'] }}" class="elite-info-value" style="text-decoration:none;">{{ $sidebarItem['value'] }}</a>
                                        @else
                                            <span class="elite-info-value">{{ $sidebarItem['value'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </aside>

        <main class="elite-main">
            <div class="elite-card">
                <div class="elite-card-body">
                    <h3 class="elite-card-title">التصنيفات</h3>
                    <div class="elite-categories">
                        @foreach($categories as $category)
                            @php($firstItem = $category->products->first())
                            <a href="#cat-{{ $category->id }}" class="elite-cat">
                                <div class="elite-cat-ring"><div class="elite-cat-inner"><img src="{{ $firstItem?->image_path ? asset('storage/'.$firstItem->image_path) : 'https://via.placeholder.com/300x300?text=Food' }}" alt="{{ $category->name_ar }}"></div></div>
                                <div class="elite-cat-label">{{ $category->name_ar }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="elite-feed">
                @if($allItemsCount > 0)
                    @foreach($categories as $category)
                        @if($category->products->count())
                            <section class="elite-section" id="cat-{{ $category->id }}">
                                <div class="elite-section-head">
                                    <h3 class="elite-section-title">{{ $category->name_ar }}</h3>
                                    <span class="elite-section-count">{{ $category->products->count() }} صنف</span>
                                </div>
                                <div class="elite-products">
                                    @foreach($category->products as $item)
                                        <article class="elite-product">
                                            <div class="elite-product-media">
                                                <img src="{{ $item->image_path ? asset('storage/'.$item->image_path) : 'https://via.placeholder.com/600x400?text=Food' }}" alt="{{ $item->name }}" class="elite-product-image">
                                                <span class="elite-product-badge">{{ $item->is_featured ? 'مميز' : 'متاح' }}</span>
                                            </div>
                                            <div class="elite-product-body">
                                                <div class="elite-product-top">
                                                    <h4 class="elite-product-name">{{ $item->name }}</h4>
                                                    <span class="elite-product-category">{{ $category->name_ar }}</span>
                                                </div>
                                                @if($item->description)
                                                    <p class="elite-product-desc">{{ $item->description }}</p>
                                                @endif
                                                <div class="elite-product-bottom">
                                                    <div>
                                                        <div class="elite-price-label">السعر</div>
                                                        <div class="elite-price-value">{{ number_format($item->price, 2) }} ج.م</div>
                                                    </div>
                                                    @if($item->is_featured)<span class="elite-badge">مميز</span>@endif
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach
                @else
                    <div class="elite-empty">لا توجد أصناف متاحة حالياً.</div>
                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
