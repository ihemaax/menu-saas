<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoTitle ?? $restaurant->name.' | المنيو' }}</title>
    @include('partials.seo')
    @include('partials.menu-structured-data')
    <!-- Dynamic Favicon (Restaurant Logo) -->
    <link rel="icon" href="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=300&auto=format&fit=crop' }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        :root{--bg:#061712;--bg2:#0b211a;--panel:#102920;--panel2:#153429;--gold:#e9c36a;--gold2:#b98b34;--cream:#fff3cf;--text:#fff9ea;--muted:#b9a77e;--line:rgba(233,195,106,.24);--soft:rgba(255,249,234,.07);--shadow:0 24px 70px rgba(0,0,0,.36)}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;min-width:320px;overflow-x:hidden;font-family:'Cairo',system-ui,sans-serif;background:radial-gradient(circle at 50% -18%,rgba(233,195,106,.18),transparent 32%),linear-gradient(180deg,#061712 0%,#091d17 42%,#04100d 100%);color:var(--text)}
        body:before{content:"";position:fixed;inset:0;pointer-events:none;background:linear-gradient(90deg,rgba(233,195,106,.035) 1px,transparent 1px),linear-gradient(rgba(255,255,255,.018) 1px,transparent 1px);background-size:58px 58px;mask-image:linear-gradient(to bottom,#000,transparent 72%);opacity:.7}
        a{color:inherit}.shell{position:relative;width:min(1220px,100%);margin:0 auto;padding:18px 18px 34px}.brand-bar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}.brand-mark{display:flex;align-items:center;gap:11px;min-width:0}.brand-logo{width:48px;height:48px;border-radius:50%;overflow:hidden;border:1px solid rgba(233,195,106,.44);background:#082019;display:grid;place-items:center;color:var(--gold);font-weight:900;box-shadow:0 0 0 4px rgba(233,195,106,.06)}.brand-logo img{width:100%;height:100%;object-fit:cover}.brand-title{margin:0;font-size:.98rem;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.brand-sub{margin:0;color:var(--muted);font-size:.72rem;font-weight:800;text-transform:uppercase}.top-actions{display:flex;gap:8px;align-items:center}.top-pill{border:1px solid var(--line);border-radius:999px;background:rgba(255,249,234,.06);padding:7px 11px;color:var(--cream);font-size:.76rem;font-weight:900;white-space:nowrap}
        .hero{position:relative;isolation:isolate;overflow:hidden;border:1px solid var(--line);border-radius:30px;background:linear-gradient(140deg,rgba(16,41,32,.96),rgba(5,18,14,.98));box-shadow:var(--shadow)}.hero:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(4,16,13,.78),rgba(4,16,13,.38)),url('{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : '' }}') center/cover no-repeat;opacity:{{ $restaurant->banner_path ? '.75' : '0' }};z-index:-2}.hero:after{content:"";position:absolute;inset:18px;border:1px solid rgba(233,195,106,.18);border-radius:22px;pointer-events:none}.hero-inner{display:grid;grid-template-columns:180px minmax(0,1fr) auto;gap:24px;align-items:center;min-height:250px;padding:34px}.logo-card{width:180px;aspect-ratio:1;border-radius:28px;overflow:hidden;border:1px solid rgba(233,195,106,.5);background:radial-gradient(circle,rgba(233,195,106,.14),rgba(255,255,255,.03));box-shadow:inset 0 0 36px rgba(233,195,106,.08),0 20px 42px rgba(0,0,0,.32);display:grid;place-items:center;color:var(--gold);font-size:2.2rem;font-weight:900}.logo-card img{width:100%;height:100%;object-fit:cover}.hero-copy{min-width:0}.kicker{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--line);border-radius:999px;background:rgba(233,195,106,.1);padding:7px 13px;color:var(--gold);font-size:.74rem;font-weight:900;text-transform:uppercase}.kicker:before{content:"";width:7px;height:7px;border-radius:50%;background:var(--gold);box-shadow:0 0 16px var(--gold)}.hero h1{margin:13px 0 4px;color:var(--cream);font-size:clamp(2.2rem,4.5vw,4.6rem);line-height:1.04;font-weight:900}.tagline{margin:0;color:var(--gold);font-size:clamp(1rem,1.8vw,1.25rem);font-weight:900}.desc{max-width:680px;margin:10px 0 0;color:var(--muted);line-height:1.8;font-weight:700}.hero-stats{display:grid;gap:10px}.stat{min-width:128px;border:1px solid var(--line);border-radius:20px;background:rgba(5,18,14,.58);padding:13px 15px;text-align:center}.stat strong{display:block;color:var(--cream);font-size:1.15rem;line-height:1}.stat span{display:block;margin-top:5px;color:var(--muted);font-size:.72rem;font-weight:900}
        .category-wrap{position:sticky;top:0;z-index:20;margin:14px -18px 22px;padding:10px 18px;background:linear-gradient(180deg,rgba(6,23,18,.96),rgba(6,23,18,.84));backdrop-filter:blur(14px);border-block:1px solid rgba(233,195,106,.14)}.categories{display:flex;gap:9px;overflow-x:auto;overscroll-behavior-x:contain;scroll-snap-type:x proximity;padding:2px 0 6px}.categories::-webkit-scrollbar{height:4px}.categories::-webkit-scrollbar-thumb{background:rgba(233,195,106,.38);border-radius:99px}.cat-link{flex:0 0 auto;display:flex;align-items:center;gap:9px;text-decoration:none;border:1px solid var(--line);border-radius:999px;background:rgba(255,249,234,.055);padding:7px 12px 7px 7px;color:var(--cream);scroll-snap-align:start;transition:.18s ease}.cat-link:hover,.cat-link.is-active{background:linear-gradient(135deg,var(--gold),var(--gold2));border-color:transparent;color:#082019}.cat-thumb{width:36px;height:36px;border-radius:50%;overflow:hidden;background:#173429;flex:0 0 auto;border:1px solid rgba(255,249,234,.16)}.cat-thumb img{width:100%;height:100%;object-fit:cover}.cat-name{font-size:.8rem;font-weight:900;white-space:nowrap}.cat-count{font-size:.66rem;color:var(--muted);font-weight:900;margin-inline-start:2px}.cat-link:hover .cat-count,.cat-link.is-active .cat-count{color:rgba(8,32,25,.72)}
        .menu{display:grid;gap:30px}.section{scroll-margin-top:96px}.section-head{position:relative;display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:14px}.section-head:after{content:"";height:1px;flex:1;background:linear-gradient(90deg,rgba(233,195,106,.34),transparent);order:2}.section-title{order:1;margin:0;color:var(--gold);font-size:clamp(1.35rem,2.5vw,2.15rem);font-weight:900}.section-count{order:3;border:1px solid var(--line);border-radius:999px;background:rgba(233,195,106,.08);padding:7px 11px;color:var(--muted);font-size:.74rem;font-weight:900;white-space:nowrap}.products{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.product{position:relative;display:grid;grid-template-columns:132px minmax(0,1fr) auto;gap:14px;align-items:center;min-width:0;overflow:hidden;border:1px solid rgba(233,195,106,.2);border-radius:20px;background:linear-gradient(135deg,rgba(255,249,234,.085),rgba(255,249,234,.035));box-shadow:0 12px 30px rgba(0,0,0,.18);padding:10px;transition:.18s ease}.product:hover{transform:translateY(-2px);border-color:rgba(233,195,106,.42);background:linear-gradient(135deg,rgba(255,249,234,.11),rgba(255,249,234,.045));box-shadow:0 18px 38px rgba(0,0,0,.26)}.media{position:relative;width:132px;aspect-ratio:1;border-radius:16px;overflow:hidden;background:linear-gradient(135deg,rgba(233,195,106,.16),rgba(255,249,234,.04));border:1px solid rgba(233,195,106,.13)}.media img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .35s ease}.product:hover .media img{transform:scale(1.04)}.no-image{height:100%;display:grid;place-items:center;text-align:center;color:var(--gold);font-weight:900;font-size:.78rem}.featured{position:absolute;top:8px;inset-inline-start:8px;border-radius:999px;background:rgba(6,23,18,.82);border:1px solid rgba(233,195,106,.28);padding:4px 8px;color:var(--gold);font-size:.62rem;font-weight:900;backdrop-filter:blur(8px)}.product-body{min-width:0;display:grid;gap:7px}.product-name{margin:0;color:var(--text);font-size:1rem;font-weight:900;line-height:1.45;overflow-wrap:anywhere}.product-desc{margin:0;color:var(--muted);font-size:.78rem;font-weight:700;line-height:1.55;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.product-category{color:rgba(233,195,106,.78);font-size:.68rem;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.price{align-self:center;display:grid;place-items:center;min-width:96px;min-height:54px;border-radius:16px;background:linear-gradient(135deg,var(--gold),var(--gold2));color:#071b15;padding:8px 10px;font-size:.92rem;font-weight:1000;white-space:nowrap;box-shadow:0 10px 24px rgba(233,195,106,.15)}.empty{border:1px solid var(--line);border-radius:22px;background:var(--soft);padding:28px;text-align:center;color:var(--muted);font-weight:900}.menu-credit-wrapper{direction:ltr!important;unicode-bidi:isolate!important;text-align:center;margin:28px 0 4px}.menu-credit-badge{direction:ltr!important;unicode-bidi:isolate!important;display:inline-flex;align-items:center;justify-content:center;text-align:center;white-space:nowrap;text-decoration:none;padding:9px 15px;border-radius:999px;background:rgba(255,249,234,.06);border:1px solid var(--line);color:var(--gold);font-size:.82rem;font-weight:900;box-shadow:0 10px 24px rgba(0,0,0,.16)}.menu-credit-badge bdi{direction:ltr!important;unicode-bidi:isolate!important;display:inline-block}
        @media (max-width:1040px){.hero-inner{grid-template-columns:140px minmax(0,1fr)}.logo-card{width:140px}.hero-stats{grid-column:1/-1;display:flex;flex-wrap:wrap}.stat{text-align:start}.products{grid-template-columns:1fr}}
        @media (max-width:640px){.shell{padding:10px 10px 26px}.brand-bar{margin-bottom:10px}.top-actions .top-pill:first-child{display:none}.hero{border-radius:22px}.hero:after{inset:10px;border-radius:16px}.hero-inner{grid-template-columns:82px minmax(0,1fr);gap:12px;min-height:0;padding:18px}.logo-card{width:82px;border-radius:18px;font-size:1.2rem}.kicker{font-size:.62rem;padding:5px 9px}.hero h1{font-size:1.45rem;margin:7px 0 2px}.tagline{font-size:.82rem}.desc{display:none}.hero-stats{display:flex;gap:7px}.stat{flex:1;min-width:0;border-radius:14px;padding:8px}.stat strong{font-size:.88rem}.stat span{font-size:.62rem}.category-wrap{margin:10px -10px 16px;padding:8px 10px}.cat-link{gap:7px;padding:6px 10px 6px 6px}.cat-thumb{width:32px;height:32px}.cat-name{font-size:.74rem}.cat-count{display:none}.menu{gap:24px}.section{scroll-margin-top:78px}.section-head{margin-bottom:10px}.section-title{font-size:1.2rem}.section-count{font-size:.68rem;padding:6px 9px}.products{gap:10px}.product{grid-template-columns:96px minmax(0,1fr);gap:10px;border-radius:17px;padding:8px}.media{width:96px;border-radius:13px}.product-body{gap:5px}.product-name{font-size:.86rem;line-height:1.38}.product-desc{font-size:.72rem;line-height:1.45;-webkit-line-clamp:1}.product-category{display:none}.price{grid-column:2;justify-self:start;min-width:0;min-height:0;border-radius:999px;padding:6px 9px;font-size:.76rem}.product:hover{transform:none}.product:hover .media img{transform:none}.featured{font-size:.56rem;padding:3px 6px}.menu-credit-wrapper{margin-top:20px}.menu-credit-badge{font-size:.74rem;padding:8px 12px}}
        @media (max-width:360px){.brand-sub{display:none}.hero-inner{grid-template-columns:70px minmax(0,1fr);padding:14px}.logo-card{width:70px}.hero h1{font-size:1.24rem}.product{grid-template-columns:84px minmax(0,1fr)}.media{width:84px}.product-name{font-size:.81rem}.price{font-size:.7rem}}
    </style>
</head>
<body>
@php($allItemsCount = $categories->sum(fn ($category) => $category->products->count()))
<div class="shell">
    <div class="brand-bar">
        <div class="brand-mark">
            <div class="brand-logo">
                @if($restaurant->logo_path)
                    <img src="{{ asset('storage/'.$restaurant->logo_path) }}" alt="{{ $restaurant->name }}">
                @else
                    SC
                @endif
            </div>
            <div>
                <p class="brand-title">{{ $restaurant->name }}</p>
                <p class="brand-sub">Restaurant menu</p>
            </div>
        </div>
        <div class="top-actions">
            @if($restaurant->phone)<span class="top-pill">{{ $restaurant->phone }}</span>@endif
            <span class="top-pill">{{ $allItemsCount }} items</span>
        </div>
    </div>

    <header class="hero">
        <div class="hero-inner">
            <div class="logo-card" aria-label="{{ $restaurant->name }} logo">
                @if($restaurant->logo_path)
                    <img src="{{ asset('storage/'.$restaurant->logo_path) }}" alt="{{ $restaurant->name }}">
                @else
                    SC
                @endif
            </div>
            <div class="hero-copy">
                <span class="kicker">Sip &amp; Chill</span>
                <h1>{{ $restaurant->name }}</h1>
                <p class="tagline">Restaurant · Coffee · Fresh Drinks</p>
                @if($restaurant->description)<p class="desc">{{ $restaurant->description }}</p>@endif
            </div>
            <div class="hero-stats">
                <div class="stat"><strong>{{ $categories->filter(fn ($category) => $category->products->count())->count() }}</strong><span>Categories</span></div>
                <div class="stat"><strong>{{ $allItemsCount }}</strong><span>Items</span></div>
            </div>
        </div>
    </header>

    @if($categories->isNotEmpty())
        <nav class="category-wrap" aria-label="Menu categories">
            <div class="categories">
                @foreach($categories as $category)
                    @if($category->products->count())
                        @php($previewItem = $category->products->first())
                        <a class="cat-link" href="#cat-{{ $category->id }}">
                            <span class="cat-thumb">
                                @if($previewItem?->image_path)
                                    <img src="{{ asset('storage/'.$previewItem->image_path) }}" alt="{{ $category->name_ar }}">
                                @endif
                            </span>
                            <span class="cat-name">{{ $category->name_ar }}</span>
                            <span class="cat-count">{{ $category->products->count() }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </nav>
    @endif

    <main class="menu">
        @forelse($categories as $category)
            @if($category->products->count())
                <section class="section" id="cat-{{ $category->id }}">
                    <div class="section-head">
                        <h2 class="section-title">{{ $category->name_ar }}</h2>
                        <span class="section-count">{{ $category->products->count() }} items</span>
                    </div>
                    <div class="products">
                        @foreach($category->products as $item)
                            <article class="product">
                                <div class="media">
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}">
                                    @else
                                        <div class="no-image">Sip &amp; Chill</div>
                                    @endif
                                    @if($item->is_featured)<span class="featured">Featured</span>@endif
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name">{{ $item->name }}</h3>
                                    @if($item->description)<p class="product-desc">{{ $item->description }}</p>@endif
                                    <span class="product-category">{{ $category->name_ar }}</span>
                                </div>
                                <span class="price">EGP {{ number_format($item->price, 2) }}</span>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="empty">No items are available right now.</div>
        @endforelse
    </main>

    @include('menu.partials.powered-by')
</div>
<script>
    (() => {
        const links = Array.from(document.querySelectorAll('.cat-link'));
        const sections = Array.from(document.querySelectorAll('.section'));

        if (!links.length || !sections.length) return;

        const activate = (id) => {
            links.forEach((link) => {
                const isActive = link.getAttribute('href') === `#${id}`;
                link.classList.toggle('is-active', isActive);
                if (isActive) link.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            });
        };

        activate(sections[0].id);
        links.forEach((link) => link.addEventListener('click', () => activate(link.getAttribute('href').slice(1))));

        if (!('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver((entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (visible) activate(visible.target.id);
        }, { rootMargin: '-22% 0px -62% 0px', threshold: [0.05, 0.2, 0.45] });

        sections.forEach((section) => observer.observe(section));
    })();
</script>
</body>
</html>
