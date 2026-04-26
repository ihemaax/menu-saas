<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | المنيو</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        :root{--bg:#f3f5ef;--card:#ffffff;--ink:#203025;--muted:#627063;--brand:#4d6b40;--accent:#8b5a35;--line:#dce6d8}
        *{box-sizing:border-box} body{margin:0;font-family:'Cairo',sans-serif;background:radial-gradient(circle at top,#f8fbf3 0,#eef3ea 45%,#e8eee5 100%);color:var(--ink)}
        .wrap{max-width:1180px;margin:0 auto;padding:16px}
        .hero{background:linear-gradient(140deg,#203025,#36553b);border-radius:28px;overflow:hidden;border:1px solid #2f4734;box-shadow:0 24px 55px rgba(30,52,36,.25)}
        .hero-cover{height:260px;background:linear-gradient(0deg,rgba(17,26,18,.5),rgba(17,26,18,.18)),url('{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1600&auto=format&fit=crop" }}') center/cover no-repeat}
        .hero-body{display:grid;grid-template-columns:auto 1fr;gap:18px;align-items:center;padding:18px;margin-top:-65px}
        .logo{width:130px;height:130px;border-radius:50%;border:6px solid rgba(255,255,255,.95);background:url('{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : "https://via.placeholder.com/600x600?text=Logo" }}') center/cover no-repeat #fff;box-shadow:0 18px 30px rgba(0,0,0,.25)}
        .hero-card{background:rgba(255,255,255,.97);border:1px solid #d9e3d5;border-radius:24px;padding:16px}
        .kicker{display:inline-flex;padding:6px 12px;border-radius:999px;background:#ebf3e8;color:var(--brand);font-weight:800;font-size:.75rem}
        h1{margin:8px 0 2px;font-size:2rem}
        .sub{margin:0;color:var(--muted);font-weight:700}
        .meta{display:flex;gap:10px;flex-wrap:wrap;margin-top:12px}
        .pill{background:#f3f7f1;border:1px solid #dce7d8;color:#3c4e3f;padding:8px 12px;border-radius:999px;font-weight:800;font-size:.82rem}
        .layout{display:grid;grid-template-columns:1fr;gap:16px;margin-top:16px}
        .panel{background:var(--card);border:1px solid var(--line);border-radius:22px;box-shadow:0 8px 24px rgba(30,52,36,.06)}
        .panel h3{margin:0;padding:16px 16px 8px;font-size:1.2rem}
        .cats{display:flex;gap:12px;overflow-x:auto;padding:0 16px 16px;scroll-snap-type:x mandatory}
        .cats::-webkit-scrollbar{height:6px}.cats::-webkit-scrollbar-thumb{background:#c5d4c0;border-radius:99px}
        .cat{min-width:100px;flex:0 0 100px;text-decoration:none;color:#37473a;text-align:center;scroll-snap-align:start}
        .cat-img{width:86px;height:86px;border-radius:50%;margin:0 auto 8px;border:3px solid #e2ebde;overflow:hidden;box-shadow:0 8px 20px rgba(28,50,33,.12)}
        .cat-img img{width:100%;height:100%;object-fit:cover}
        .cat-name{font-weight:800;font-size:.82rem;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.2em}
        .section{padding:14px}
        .section{scroll-margin-top:20px;scroll-margin-bottom:96px}
        .sec-head{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:4px 2px 10px}
        .sec-title{margin:0;font-size:1.4rem;color:#1f2f23}
        .count{background:#edf4eb;color:#46603e;padding:7px 12px;border-radius:999px;font-weight:800}
        .items{display:grid;gap:12px}
        .item{display:grid;grid-template-columns:120px 1fr;gap:12px;background:#fff;border:1px solid #e0eadc;border-radius:18px;overflow:hidden}
        .item img{width:100%;height:100%;min-height:110px;object-fit:cover}
        .item-body{padding:12px;display:grid;gap:8px}
        .name{margin:0;font-size:1.12rem}.desc{margin:0;color:var(--muted);font-weight:700;font-size:.9rem}
        .bottom{display:flex;align-items:center;justify-content:space-between;gap:10px}
        .price{font-size:1.1rem;font-weight:900;color:var(--accent)}
        .badge{background:#e9f2e6;color:#35592f;padding:6px 10px;border-radius:999px;font-weight:800;font-size:.75rem}
        .mobile-catbar{display:none}
        @media (max-width:768px){
            .wrap{padding:10px}.hero-body{grid-template-columns:1fr;margin-top:-45px;padding:12px}.logo{width:118px;height:118px;margin:0 auto}
            h1{font-size:1.4rem;text-align:center}.sub{text-align:center}.meta{justify-content:center}.item{grid-template-columns:92px 1fr}.item img{min-height:92px}
            .cat{min-width:86px;flex-basis:86px}.cat-img{width:72px;height:72px}
            .cats-panel{display:none}
            .wrap{padding-bottom:110px}
            .mobile-catbar{display:flex;position:fixed;left:10px;right:10px;bottom:12px;z-index:60;gap:8px;overflow-x:auto;padding:8px;border-radius:20px;background:rgba(16,29,20,.78);backdrop-filter:blur(14px);box-shadow:0 14px 34px rgba(0,0,0,.22);scroll-snap-type:x mandatory}
            .mobile-catbar::-webkit-scrollbar{display:none}
            .mobile-cat-link{min-width:86px;flex:0 0 86px;text-decoration:none;color:#eef8eb;background:rgba(255,255,255,.06);border:1px solid rgba(220,236,215,.26);border-radius:14px;padding:7px 5px;display:grid;gap:4px;justify-items:center;scroll-snap-align:start}
            .mobile-cat-link .thumb{width:50px;height:50px;border-radius:50%;border:2px solid rgba(238,248,233,.8);overflow:hidden;box-shadow:0 6px 16px rgba(0,0,0,.25)}
            .mobile-cat-link .thumb img{width:100%;height:100%;object-fit:cover}
            .mobile-cat-link .txt{font-size:.7rem;font-weight:800;line-height:1.28;text-align:center;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2em}
        }
    </style>
</head>
<body>
@php($allItemsCount = $categories->sum(fn($category) => $category->products->count()))
<div class="wrap">
    <section class="hero">
        <div class="hero-cover"></div>
        <div class="hero-body">
            <div class="logo"></div>
            <div class="hero-card">
                <span class="kicker">Tree Essence</span>
                <h1>{{ $restaurant->name }}</h1>
                @if($restaurant->description)<p class="sub">{{ $restaurant->description }}</p>@endif
                <div class="meta">
                    @if($restaurant->address)<span class="pill">{{ $restaurant->address }}</span>@endif
                    <span class="pill">{{ $allItemsCount }} صنف متاح</span>
                </div>
            </div>
        </div>
    </section>

    <section class="panel cats-panel">
        <h3>التصنيفات</h3>
        <div class="cats">
            @foreach($categories as $category)
                @php($firstItem = $category->products->first())
                <a href="#cat-{{ $category->id }}" class="cat">
                    <div class="cat-img"><img src="{{ $firstItem?->image_path ? asset('storage/'.$firstItem->image_path) : 'https://via.placeholder.com/300x300?text=Food' }}" alt="{{ $category->name_ar }}"></div>
                    <div class="cat-name">{{ $category->name_ar }}</div>
                </a>
            @endforeach
        </div>
    </section>

    @foreach($categories as $category)
        @if($category->products->count())
            <section class="panel section" id="cat-{{ $category->id }}">
                <div class="sec-head">
                    <h2 class="sec-title">{{ $category->name_ar }}</h2>
                    <span class="count">{{ $category->products->count() }} صنف</span>
                </div>
                <div class="items">
                    @foreach($category->products as $item)
                        <article class="item">
                            <img src="{{ $item->image_path ? asset('storage/'.$item->image_path) : 'https://via.placeholder.com/500x350?text=Food' }}" alt="{{ $item->name }}">
                            <div class="item-body">
                                <h4 class="name">{{ $item->name }}</h4>
                                @if($item->description)<p class="desc">{{ $item->description }}</p>@endif
                                <div class="bottom">
                                    <span class="price">{{ number_format($item->price, 2) }} ج.م</span>
                                    @if($item->is_featured)<span class="badge">مميز</span>@endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach

    <nav class="mobile-catbar" aria-label="التصنيفات">
        @foreach($categories as $category)
            @if($category->products->count())
                @php($mobileCatPreview = $category->products->first())
                <a href="#cat-{{ $category->id }}" class="mobile-cat-link">
                    <span class="thumb"><img src="{{ $mobileCatPreview?->image_path ? asset('storage/'.$mobileCatPreview->image_path) : 'https://via.placeholder.com/300x300?text=Food' }}" alt="{{ $category->name_ar }}"></span>
                    <span class="txt">{{ $category->name_ar }}</span>
                </a>
            @endif
        @endforeach
    </nav>
</div>
</body>
</html>
