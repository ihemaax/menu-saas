<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} - {{ __('Menu') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --zz-bg: #f6f2ea;
            --zz-surface: #fffdf9;
            --zz-border: #e9dece;
            --zz-text: #20302a;
            --zz-sub: #6f675b;
            --zz-brand: #124638;
            --zz-brand-2: #2f7763;
            --zz-safe-bottom: calc(70px + env(safe-area-inset-bottom, 0px));
        }

        body {
            overflow-x: hidden;
            background: var(--zz-bg);
            font-family: "Cairo", sans-serif;
            color: var(--zz-text);
        }

        .menu-home {
            width: 100%;
            max-width: 100%;
            color: var(--zz-text);
            padding: 0 0 calc(var(--zz-safe-bottom) + 8px);
        }

        .menu-shell {
            width: 100%;
            max-width: min(980px, 100%);
            margin: 0 auto;
            padding: 0 12px;
        }

        .mobile-top {
            position: sticky;
            top: 0;
            z-index: 40;
            background: color-mix(in srgb, var(--zz-bg) 92%, white);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--zz-border);
        }

        .mobile-top-inner {
            display: grid;
            gap: 10px;
            padding: 10px 0 12px;
        }

        .mobile-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .identity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .identity-logo {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            flex-shrink: 0;
            background: url('{{ $tenant->logo ? asset("storage/" . $tenant->logo) : "https://via.placeholder.com/300x300?text=Logo" }}') center/cover no-repeat;
            box-shadow: 0 10px 18px rgba(16, 43, 35, 0.18);
        }

        .identity-name {
            margin: 0;
            font-size: .98rem;
            font-weight: 900;
            line-height: 1.3;
        }

        .identity-status {
            font-size: .72rem;
            font-weight: 800;
            border-radius: 999px;
            padding: 4px 9px;
            background: #eef8f2;
            color: #1d7458;
            border: 1px solid #cfe8da;
        }

        .identity-status.closed {
            background: #fff2f2;
            color: #912f2f;
            border-color: #f3d2d2;
        }

        .stories-wrap {
            padding-top: 12px;
        }

        .stories-row {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 4px 2px 6px;
            scrollbar-width: none;
            overscroll-behavior-inline: contain;
            scroll-snap-type: x proximity;
        }

        .stories-row::-webkit-scrollbar {
            display: none;
        }

        .story-chip {
            border: none;
            background: transparent;
            color: #5f584e;
            border-radius: 18px;
            padding: 2px;
            font-size: .72rem;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            min-width: 68px;
            scroll-snap-align: start;
        }

        .story-thumb {
            width: 60px;
            height: 60px;
            border-radius: 999px;
            padding: 2px;
            background: linear-gradient(140deg, #0f4032, #2e7762);
            box-shadow: 0 8px 18px rgba(17, 55, 45, .18);
            flex-shrink: 0;
            display: inline-flex;
        }

        .story-thumb img {
            width: 100%;
            height: 100%;
            border-radius: 999px;
            object-fit: cover;
            border: 2px solid #fff;
            background: #f3ece1;
        }

        .story-label {
            display: block;
            max-width: 72px;
            text-align: center;
            line-height: 1.25;
            color: #5f584e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .story-chip.active .story-thumb {
            background: linear-gradient(140deg, #0b352a, #1c5d4d);
        }

        .story-chip.active .story-label {
            color: #1a4b3e;
        }

        .page-feed {
            display: grid;
            gap: 12px;
            padding-top: 10px;
        }

        .section-card {
            background: var(--zz-surface);
            border: 1px solid var(--zz-border);
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(26, 36, 31, 0.07);
            padding: 13px;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 12px;
            padding-top: 8px;
        }

        .section-title {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--zz-text);
        }

        .section-sub {
            margin: 2px 0 0;
            font-size: .74rem;
            color: var(--zz-sub);
            font-weight: 600;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 9px;
        }

        .menu-item {
            border: 1px solid #ecdfcf;
            border-radius: 16px;
            background: #fff;
            padding: 12px;
            display: flex;
            flex-direction: row;
            gap: 12px;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .menu-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .product-image-wrap {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }

        .menu-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.2s ease;
        }

        .menu-item:hover img {
            transform: scale(1.05);
        }

        .menu-badge {
            position: absolute;
            top: 8px;
            inset-inline-start: 8px;
            background: var(--zz-brand);
            color: white;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 12px;
            z-index: 1;
        }

        .product-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 0;
        }

        .product-name {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--zz-text);
        }

        .product-desc {
            margin: 0;
            font-size: 0.8rem;
            color: #6e6659;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: auto;
        }

        .product-price {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--zz-brand);
        }

        .add-to-cart-btn {
            background: linear-gradient(135deg, var(--zz-brand), var(--zz-brand-2));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .add-to-cart-btn:hover {
            background: linear-gradient(135deg, var(--zz-brand-2), var(--zz-brand));
        }

        .add-to-cart-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .featured-strip {
            display: grid;
            gap: 8px;
        }

        .featured-item {
            border: 1px solid #efe2d0;
            border-radius: 14px;
            background: #fff;
            padding: 10px;
            display: grid;
            grid-template-columns: 62px minmax(0,1fr) auto;
            gap: 10px;
            align-items: center;
        }

        .featured-item img {
            width: 62px;
            height: 62px;
            border-radius: 11px;
            object-fit: cover;
        }

        .featured-item h4 {
            margin: 0;
            font-size: .84rem;
            font-weight: 900;
            line-height: 1.45;
        }

        .featured-item p {
            margin: 2px 0 0;
            font-size: .72rem;
            color: #786f60;
        }
    </style>
</head>
<body>
    <div class="menu-home">
        <div class="menu-shell">
            <div class="mobile-top">
                <div class="mobile-top-inner">
                    <div class="mobile-head">
                        <div class="identity">
                            <div class="identity-logo"></div>
                            <div>
                                <h1 class="identity-name">{{ $tenant->name }}</h1>
                                <div class="identity-status {{ $tenant->is_open ? '' : 'closed' }}">
                                    {{ $tenant->is_open ? __('Open') : __('Closed') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($categories->count() > 0)
            <div class="stories-wrap">
                <div class="stories-row">
                    @foreach($categories as $category)
                    <a href="#category-{{ $category->id }}" class="story-chip">
                        <div class="story-thumb">
                            <div style="width: 100%; height: 100%; border-radius: 999px; background: #f3ece1; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-tags" style="color: #5f584e; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <span class="story-label">{{ $category->name_ar }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="page-feed">
                @if($featuredProducts->count() > 0)
                <div class="section-card">
                    <div class="section-head">
                        <div>
                            <h2 class="section-title">{{ __('Featured Products') }}</h2>
                            <p class="section-sub">{{ __('Special dishes from our menu') }}</p>
                        </div>
                    </div>
                    <div class="featured-strip">
                        @foreach($featuredProducts as $product)
                        <div class="featured-item">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div style="width: 62px; height: 62px; border-radius: 11px; background: #efe4d3; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-image" style="color: #786f60;"></i>
                                </div>
                            @endif
                            <div>
                                <h4>{{ $product->name }}</h4>
                                <p>{{ Str::limit($product->description, 50) }}</p>
                            </div>
                            <div class="product-price">{{ number_format($product->price, 2) }} {{ __('SAR') }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @foreach($categories as $category)
                <div id="category-{{ $category->id }}" class="section-card">
                    <div class="section-head">
                        <div>
                            <h2 class="section-title">{{ $category->name_ar }}</h2>
                            <p class="section-sub">{{ $category->name_en }} • {{ $category->products->count() }} {{ __('items') }}</p>
                        </div>
                    </div>
                    <div class="menu-grid">
                        @foreach($category->products->where('is_available', true)->sortBy('order') as $product)
                        <div class="menu-item">
                            @if($product->is_featured)
                                <div class="menu-badge">{{ __('Featured') }}</div>
                            @endif
                            <div class="product-image-wrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <div style="width: 100%; height: 100%; background: #efe4d3; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image" style="color: #6e6659; font-size: 1.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="product-content">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                @if($product->description)
                                    <p class="product-desc">{{ $product->description }}</p>
                                @endif
                                <div class="product-footer">
                                    <div class="product-price">{{ number_format($product->price, 2) }} {{ __('SAR') }}</div>
                                    @if($tenant->is_open)
                                        <button class="add-to-cart-btn" {{ !$product->is_available ? 'disabled' : '' }}>
                                            <i class="bi bi-plus-circle"></i>
                                            {{ __('Add') }}
                                        </button>
                                    @else
                                        <button class="add-to-cart-btn" disabled>
                                            <i class="bi bi-clock"></i>
                                            {{ __('Closed') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                @if($categories->count() == 0)
                <div class="section-card">
                    <div class="text-center py-5">
                        <i class="bi bi-shop display-4 text-muted mb-3"></i>
                        <h4>{{ __('Menu Coming Soon') }}</h4>
                        <p class="text-muted">{{ __('Our menu is being prepared. Please check back later.') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>