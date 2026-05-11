<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | Sipchill Menu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        :root{--bg:#061b16;--bg2:#071f19;--card:rgba(255,255,255,.06);--card-solid:#0d2a22;--gold:#d9b76a;--gold2:#cfaf5a;--cream:#f7eac8;--muted:#b8aa83;--line:rgba(217,183,106,.25);--white:#fffaf0;--danger:#ffb7a1}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;min-width:320px;overflow-x:hidden;font-family:'Cairo',system-ui,sans-serif;background:radial-gradient(circle at 12% -10%,rgba(217,183,106,.2),transparent 28%),radial-gradient(circle at 92% 8%,rgba(247,234,200,.08),transparent 26%),linear-gradient(145deg,var(--bg),var(--bg2) 52%,#03110e);color:var(--cream)}
        body:before{content:"";position:fixed;inset:0;pointer-events:none;background:linear-gradient(rgba(255,255,255,.018) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.014) 1px,transparent 1px);background-size:44px 44px;mask-image:linear-gradient(to bottom,rgba(0,0,0,.7),transparent 72%)}
        a{color:inherit}.page{width:min(1180px,100%);margin:0 auto;padding:14px 14px 28px}.hero{position:relative;isolation:isolate;overflow:hidden;border:1px solid var(--line);border-radius:30px;background:linear-gradient(135deg,rgba(13,42,34,.94),rgba(6,27,22,.94));box-shadow:0 24px 70px rgba(0,0,0,.32),0 0 42px rgba(217,183,106,.08)}
        .hero:before{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(3,17,14,.42),rgba(3,17,14,.72)),url('{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : '' }}') center/cover no-repeat;opacity:{{ $restaurant->banner_path ? '.42' : '0' }};z-index:-2}.hero:after{content:"";position:absolute;width:360px;height:360px;border-radius:50%;left:-130px;top:-160px;background:radial-gradient(circle,rgba(217,183,106,.26),transparent 64%);filter:blur(4px);z-index:-1}
        .hero-inner{display:grid;grid-template-columns:auto 1fr;gap:18px;align-items:center;min-height:245px;padding:26px}.logo{width:122px;height:122px;border-radius:28px;border:1px solid rgba(217,183,106,.5);background:linear-gradient(145deg,rgba(217,183,106,.18),rgba(255,255,255,.05));box-shadow:inset 0 0 24px rgba(217,183,106,.1),0 18px 34px rgba(0,0,0,.28);overflow:hidden;display:grid;place-items:center;color:var(--gold);font-size:2.4rem;font-weight:900;letter-spacing:.04em}.logo img{width:100%;height:100%;object-fit:cover}.hero-copy{min-width:0}.eyebrow{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--line);border-radius:999px;background:rgba(217,183,106,.12);padding:7px 13px;color:var(--gold);font-weight:900;font-size:.78rem;letter-spacing:.08em;text-transform:uppercase}.hero h1{margin:12px 0 4px;font-size:clamp(2rem,5vw,4.4rem);line-height:1.08;color:var(--cream);text-wrap:balance}.tagline{margin:0;color:var(--gold);font-weight:800;font-size:clamp(1rem,2.4vw,1.35rem)}.desc{margin:10px 0 0;max-width:680px;color:var(--muted);font-size:.98rem;font-weight:700;line-height:1.8}.meta{display:flex;flex-wrap:wrap;gap:9px;margin-top:16px}.pill{display:inline-flex;align-items:center;gap:7px;max-width:100%;border:1px solid var(--line);border-radius:999px;background:rgba(255,255,255,.06);padding:8px 12px;color:var(--cream);font-size:.82rem;font-weight:800}.pill span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .category-shell{position:sticky;top:0;z-index:10;margin:14px -14px 10px;padding:10px 14px;background:linear-gradient(180deg,rgba(6,27,22,.98),rgba(6,27,22,.78));backdrop-filter:blur(12px);border-bottom:1px solid rgba(217,183,106,.12)}.categories{display:flex;gap:9px;overflow-x:auto;overscroll-behavior-x:contain;scroll-snap-type:x proximity;padding:3px 0 8px}.categories::-webkit-scrollbar{height:5px}.categories::-webkit-scrollbar-thumb{background:rgba(217,183,106,.45);border-radius:99px}.cat-link{flex:0 0 auto;scroll-snap-align:start;text-decoration:none;border:1px solid var(--line);border-radius:999px;background:rgba(255,255,255,.05);padding:9px 14px;color:var(--cream);font-size:.86rem;font-weight:900;white-space:nowrap;transition:background .2s ease,color .2s ease,transform .2s ease,border-color .2s ease}.cat-link:hover,.cat-link:focus,.cat-link.is-active{background:var(--gold);border-color:var(--gold);color:#082019;transform:translateY(-1px)}
        .content{display:grid;gap:18px;margin-top:14px}.section{scroll-margin-top:90px}.section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px;padding:0 4px}.section-title{margin:0;color:var(--gold);font-size:clamp(1.35rem,3vw,2.1rem);line-height:1.2}.count{flex:0 0 auto;border:1px solid var(--line);border-radius:999px;background:rgba(217,183,106,.11);padding:7px 11px;color:var(--muted);font-size:.78rem;font-weight:900}.products{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}.product{min-width:0;overflow:hidden;border:1px solid var(--line);border-radius:24px;background:linear-gradient(155deg,rgba(255,255,255,.085),rgba(255,255,255,.035));box-shadow:0 14px 34px rgba(0,0,0,.18);transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease}.product:hover{transform:translateY(-3px);border-color:rgba(217,183,106,.45);box-shadow:0 18px 42px rgba(0,0,0,.24),0 0 24px rgba(217,183,106,.06)}.media{position:relative;height:168px;background:linear-gradient(135deg,rgba(217,183,106,.18),rgba(255,255,255,.04));overflow:hidden}.media img{width:100%;height:100%;object-fit:cover;display:block}.placeholder{height:100%;display:grid;place-items:center;text-align:center;color:rgba(247,234,200,.82);font-weight:900;letter-spacing:.08em}.placeholder:before{content:"Sip & Chill";display:grid;place-items:center;width:116px;height:116px;border-radius:50%;border:1px solid rgba(217,183,106,.34);background:radial-gradient(circle,rgba(217,183,106,.18),rgba(255,255,255,.03));box-shadow:inset 0 0 30px rgba(217,183,106,.08)}.featured{position:absolute;inset-block-start:10px;inset-inline-start:10px;border-radius:999px;background:rgba(6,27,22,.82);border:1px solid var(--line);padding:5px 9px;color:var(--gold);font-size:.72rem;font-weight:900}.product-body{display:grid;gap:11px;padding:14px}.product-name{margin:0;min-height:3.1em;color:var(--white);font-size:1.02rem;font-weight:900;line-height:1.5;overflow-wrap:anywhere;word-break:break-word}.product-desc{margin:0;color:var(--muted);font-size:.84rem;font-weight:700;line-height:1.65;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.product-foot{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:auto}.price{display:inline-flex;align-items:center;justify-content:center;border-radius:999px;background:linear-gradient(135deg,var(--gold),var(--gold2));color:#082019;padding:8px 12px;font-size:.98rem;font-weight:1000;box-shadow:0 8px 20px rgba(217,183,106,.18);white-space:nowrap}.category-tag{min-width:0;color:var(--muted);font-size:.75rem;font-weight:900;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.empty{border:1px solid var(--line);border-radius:24px;background:var(--card);padding:28px;text-align:center;color:var(--muted);font-weight:900}.menu-credit-wrapper{direction:ltr!important;unicode-bidi:isolate!important;text-align:center;margin:24px 0 4px}.menu-credit-badge{direction:ltr!important;unicode-bidi:isolate!important;display:inline-flex;align-items:center;justify-content:center;text-align:center;white-space:nowrap;text-decoration:none;padding:9px 16px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid var(--line);color:var(--gold);font-size:.84rem;font-weight:900;box-shadow:0 8px 24px rgba(0,0,0,.18)}.menu-credit-badge bdi{direction:ltr!important;unicode-bidi:isolate!important;display:inline-block}
        @media (max-width:980px){.products{grid-template-columns:repeat(2,minmax(0,1fr))}.hero-inner{min-height:220px}.media{height:154px}}
        @media (max-width:640px){.page{padding:10px 10px 22px}.hero{border-radius:24px}.hero-inner{grid-template-columns:1fr;gap:14px;min-height:0;padding:20px 16px;text-align:center}.logo{width:96px;height:96px;border-radius:24px;margin:0 auto;font-size:1.7rem}.eyebrow{font-size:.7rem;padding:6px 11px}.desc{font-size:.9rem}.meta{justify-content:center}.pill{font-size:.76rem;padding:7px 10px}.category-shell{margin:10px -10px 8px;padding:8px 10px}.cat-link{padding:8px 12px;font-size:.8rem}.section{scroll-margin-top:76px}.section-head{align-items:flex-end}.products{grid-template-columns:1fr;gap:11px}.product{display:grid;grid-template-columns:104px minmax(0,1fr);border-radius:20px}.media{height:auto;min-height:126px}.placeholder:before{width:78px;height:78px;font-size:.72rem}.product-body{padding:11px;gap:8px}.product-name{min-height:0;font-size:.93rem;line-height:1.45}.product-desc{font-size:.78rem;line-height:1.55}.product-foot{align-items:flex-end}.price{font-size:.86rem;padding:7px 10px}.category-tag{display:none}.product:hover{transform:none}.menu-credit-wrapper{margin-top:18px}.menu-credit-badge{font-size:.76rem;padding:8px 12px}}
        @media (max-width:360px){.page{padding-inline:8px}.hero-inner{padding:18px 12px}.product{grid-template-columns:92px minmax(0,1fr)}.media{min-height:118px}.section-title{font-size:1.18rem}.count{font-size:.7rem;padding:6px 9px}.product-body{padding:10px}.product-name{font-size:.88rem}.price{font-size:.8rem;padding:6px 9px}}
    </style>
</head>
<body>
@php($allItemsCount = $categories->sum(fn ($category) => $category->products->count()))
<div class="page">
    <header class="hero">
        <div class="hero-inner">
            <div class="logo" aria-label="{{ $restaurant->name }} logo">
                @if($restaurant->logo_path)
                    <img src="{{ asset('storage/'.$restaurant->logo_path) }}" alt="{{ $restaurant->name }}">
                @else
                    S&C
                @endif
            </div>
            <div class="hero-copy">
                <span class="eyebrow">Sipchill</span>
                <h1>{{ $restaurant->name }}</h1>
                <p class="tagline">Sip, Chill &amp; Enjoy</p>
                @if($restaurant->description)<p class="desc">{{ $restaurant->description }}</p>@endif
                <div class="meta">
                    <span class="pill"><span>{{ $allItemsCount }} item{{ $allItemsCount === 1 ? '' : 's' }}</span></span>
                    @if($restaurant->phone)<span class="pill"><span>{{ $restaurant->phone }}</span></span>@endif
                    @if($restaurant->address)<span class="pill"><span>{{ $restaurant->address }}</span></span>@endif
                </div>
            </div>
        </div>
    </header>

    @if($categories->isNotEmpty())
        <nav class="category-shell" aria-label="Menu categories">
            <div class="categories">
                @foreach($categories as $category)
                    @if($category->products->count())
                        <a class="cat-link" href="#cat-{{ $category->id }}">{{ $category->name_ar }}</a>
                    @endif
                @endforeach
            </div>
        </nav>
    @endif

    <main class="content">
        @forelse($categories as $category)
            @if($category->products->count())
                <section class="section" id="cat-{{ $category->id }}">
                    <div class="section-head">
                        <h2 class="section-title">{{ $category->name_ar }}</h2>
                        <span class="count">{{ $category->products->count() }} items</span>
                    </div>
                    <div class="products">
                        @foreach($category->products as $item)
                            <article class="product">
                                <div class="media">
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}">
                                    @else
                                        <div class="placeholder" aria-hidden="true"></div>
                                    @endif
                                    @if($item->is_featured)<span class="featured">Featured</span>@endif
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name">{{ $item->name }}</h3>
                                    @if($item->description)<p class="product-desc">{{ $item->description }}</p>@endif
                                    <div class="product-foot">
                                        <span class="category-tag">{{ $category->name_ar }}</span>
                                        <span class="price">{{ number_format($item->price, 2) }} EGP</span>
                                    </div>
                                </div>
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

        links[0].classList.add('is-active');
        links.forEach((link) => link.addEventListener('click', () => activate(link.getAttribute('href').slice(1))));

        if (!('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver((entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (visible) activate(visible.target.id);
        }, { rootMargin: '-20% 0px -65% 0px', threshold: [0.05, 0.2, 0.45] });

        sections.forEach((section) => observer.observe(section));
    })();
</script>
</body>
</html>
