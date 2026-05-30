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
    
    <!-- Google Fonts: Cairo for Arabic & Outfit for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-gradient-dark: radial-gradient(circle at top, #161512 0%, #0a0a0a 60%, #000000 100%);
            --bg-color-dark: #0a0a0a;
            --card-bg-dark: #121212;
            --text-main-dark: #ffffff;
            --text-muted-dark: #8a8a8a;
            --gold: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.25);
            --gold-border: rgba(212, 175, 55, 0.4);
            
            --bg-gradient-light: radial-gradient(circle at top, #fdfbf7 0%, #f7f4eb 60%, #ece7d5 100%);
            --bg-color-light: #f7f4eb;
            --card-bg-light: #ffffff;
            --text-main-light: #161616;
            --text-muted-light: #6a6a6a;
            
            /* Active variables */
            --bg-gradient: var(--bg-gradient-dark);
            --bg-color: var(--bg-color-dark);
            --card-bg: var(--card-bg-dark);
            --text-main: var(--text-main-dark);
            --text-muted: var(--text-muted-dark);
        }

        body.light-theme {
            --bg-gradient: var(--bg-gradient-light);
            --bg-color: var(--bg-color-light);
            --card-bg: var(--card-bg-light);
            --text-main: var(--text-main-light);
            --text-muted: var(--text-muted-light);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            font-family: 'Cairo', 'Outfit', sans-serif;
            background: var(--bg-gradient);
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 100px; /* Space for floating footer bar */
            overflow-x: hidden;
        }

        .container {
            max-width: 768px;
            margin: 0 auto;
            padding: 20px 16px;
        }

        /* HEADER SECTION */
        header {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.15);
            text-align: center;
        }

        .brand-header-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .brand-logo {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            border: 2px solid var(--gold);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
            object-fit: cover;
            background-color: #fff;
            padding: 0;
        }

        .brand-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
            margin-top: 4px;
        }

        .brand-tagline {
            font-family: 'Outfit', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.18em;
        }

        .theme-toggle-btn {
            position: absolute;
            top: 10px;
            left: 0;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid var(--gold-border);
            background: rgba(212, 175, 55, 0.08);
            color: var(--gold);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease;
        }

        .theme-toggle-btn:hover {
            transform: scale(1.05);
            background: rgba(212, 175, 55, 0.15);
            box-shadow: 0 0 12px var(--gold-glow);
        }

        /* SEARCH BAR */
        .search-container {
            position: relative;
            margin-bottom: 25px;
        }

        .search-input {
            width: 100%;
            padding: 14px 45px 14px 20px;
            border-radius: 99px;
            border: 1px solid var(--gold-border);
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-main);
            font-family: 'Cairo', sans-serif;
            font-size: 0.95rem;
            outline: none;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.4);
        }

        body.light-theme .search-input {
            background: rgba(0, 0, 0, 0.02);
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }

        .search-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 10px var(--gold-glow), inset 0 2px 4px rgba(0,0,0,0.4);
        }

        .search-icon {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 1rem;
        }

        /* CATEGORY SECTION */
        .category-section {
            margin-bottom: 35px;
            scroll-margin-top: 20px;
        }

        .category-banner {
            position: relative;
            height: 160px;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--gold-border);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .category-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            z-index: 1;
        }

        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.75) 100%);
            z-index: 2;
        }

        .category-title-wrap {
            position: relative;
            z-index: 3;
            padding: 10px;
        }

        .category-title-ar {
            font-size: 1.7rem;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
            margin-bottom: 2px;
        }

        .category-title-en {
            font-family: 'Outfit', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.2em;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8);
        }

        /* PRODUCTS LIST */
        .products-list {
            display: grid;
            gap: 16px;
            padding: 0 4px;
        }

        .product-item {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 16px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }

        .product-img {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid var(--gold-border);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25);
        }

        .product-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
            text-align: right;
        }

        .product-name-ar {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .product-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price-box {
            text-align: left;
            padding-left: 4px;
        }

        .product-price {
            font-family: 'Outfit', 'Cairo', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gold);
            white-space: nowrap;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        /* FLOATING FOOTER NAVIGATION */
        .footer-nav-bar {
            position: fixed;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 32px);
            max-width: 500px;
            background: rgba(10, 10, 10, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--gold-border);
            border-radius: 99px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            z-index: 100;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            scrollbar-width: none; /* Firefox */
        }

        body.light-theme .footer-nav-bar {
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .footer-nav-bar::-webkit-scrollbar {
            display: none; /* Safari and Chrome */
        }

        .footer-nav-item {
            flex: 0 0 auto;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 99px;
            color: var(--text-main);
            font-size: 0.88rem;
            font-weight: 700;
            background: transparent;
            border: 1px solid transparent;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .footer-nav-item.active, .footer-nav-item:hover {
            background: rgba(212, 175, 55, 0.15);
            color: var(--gold);
            border-color: var(--gold-border);
            box-shadow: 0 0 10px var(--gold-glow);
        }

        /* MODAL FOR PRODUCT DETAILS */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            padding: 16px;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            width: 100%;
            max-width: 450px;
            background: var(--card-bg);
            border: 1px solid var(--gold-border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            transform: scale(0.9);
            transition: transform 0.3s ease;
            position: relative;
        }

        .modal-overlay.open .modal-card {
            transform: scale(1);
        }

        .modal-close-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }

        .modal-close-btn:hover {
            background: rgba(212, 175, 55, 0.8);
            border-color: var(--gold);
            color: #000;
        }

        .modal-hero {
            height: 240px;
            width: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .modal-body {
            padding: 24px;
            text-align: right;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .modal-price {
            font-family: 'Outfit', 'Cairo', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 16px;
            display: inline-block;
            border-bottom: 2px solid var(--gold);
            padding-bottom: 4px;
        }

        .modal-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* POWERED BY SECTION */
        .powered-by-wrap {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .powered-by-link {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid var(--gold-border);
            border-radius: 99px;
            color: var(--text-main);
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .powered-by-link:hover {
            background: rgba(212, 175, 55, 0.12);
            box-shadow: 0 6px 20px var(--gold-glow);
        }

        .powered-by-link span {
            color: var(--gold);
            font-weight: 800;
        }

        /* EMPTY SEARCH STATE */
        .empty-search-state {
            display: none;
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .empty-search-state i {
            font-size: 3rem;
            color: var(--gold);
            margin-bottom: 15px;
            opacity: 0.6;
        }

        .empty-search-state p {
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* RESPONSIVE LAYOUT */
        @media (min-width: 769px) {
            .container {
                max-width: 1000px;
            }

            .products-list {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }

            .product-item {
                border-bottom: 1px solid rgba(212, 175, 55, 0.08);
                padding: 16px 10px;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.01);
            }

            body.light-theme .product-item {
                background: rgba(0, 0, 0, 0.005);
            }

            .product-item:hover {
                background: rgba(212, 175, 55, 0.04);
                transform: translateY(-2px);
            }
        }
    </style>
</head>
<body>

@php
    $allItemsCount = $categories->sum(fn($category) => $category->products->count());
@endphp

<div class="container">
    <!-- HEADER -->
    <header>
        <button class="theme-toggle-btn" id="themeToggle" aria-label="Toggle Theme">
            <i class="fa-solid fa-moon"></i>
        </button>
        <div class="brand-header-center">
            <img class="brand-logo" src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=300&auto=format&fit=crop' }}" alt="Logo">
            <h1 class="brand-name">{{ $restaurant->name }}</h1>
            <span class="brand-tagline">THE ART OF BREWING</span>
        </div>
    </header>

    <!-- SEARCH BAR -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="ابحث عن مشروب أو صنف مأكولات...">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>

    <!-- EMPTY STATE FOR SEARCH -->
    <div class="empty-search-state" id="emptySearch">
        <i class="fa-regular fa-face-frown"></i>
        <p>عذرًا، لم نعثر على نتائج مطابقة لبحثك.</p>
    </div>

    <!-- CATEGORIES AND PRODUCTS -->
    <div id="menuCategories">
        @foreach($categories as $category)
            @if($category->products->count())
                @php
                    $firstItem = $category->products->first();
                    
                    $categoryName = trim(mb_strtolower($category->name_ar));
                    $categoryNameEn = trim(strtolower($category->name_en ?? ''));
                    
                    $matchedImage = match(true) {
                        str_contains($categoryName, 'ساخن') || str_contains($categoryNameEn, 'hot') => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'قهو') || str_contains($categoryNameEn, 'coffee') || str_contains($categoryNameEn, 'caffe') => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'عصير') || str_contains($categoryName, 'عصائر') || str_contains($categoryNameEn, 'juice') => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'اسموز') || str_contains($categoryName, 'سموز') || str_contains($categoryNameEn, 'smoothie') => 'https://images.unsplash.com/photo-1553530666-ba11a7da3888?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'شيك') || str_contains($categoryNameEn, 'shake') => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'ايس') || str_contains($categoryName, 'بارد') || str_contains($categoryNameEn, 'iced') || str_contains($categoryNameEn, 'cold') => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'موهيتو') || str_contains($categoryNameEn, 'mojito') => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'بوبا') || str_contains($categoryNameEn, 'boba') || str_contains($categoryNameEn, 'bubble') => 'https://imgg.io/images/2026/05/26/d89b80ae2bb1f6b3534f997c4742c49d.jpg',
                        str_contains($categoryName, 'حلو') || str_contains($categoryName, 'مخبوز') || str_contains($categoryNameEn, 'dessert') || str_contains($categoryNameEn, 'sweet') || str_contains($categoryNameEn, 'bakery') => 'https://images.unsplash.com/photo-1587314168485-3236d6710814?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'كوكتيل') || str_contains($categoryNameEn, 'cocktail') => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'سوفت') || str_contains($categoryNameEn, 'soft') || str_contains($categoryName, 'غاز') => 'https://imgg.io/images/2026/05/26/5c629ff929d45d3f068bbbcd5f5c02f7.webp',
                        str_contains($categoryName, 'إضاف') || str_contains($categoryName, 'اضاف') || str_contains($categoryName, 'اضف') || str_contains($categoryNameEn, 'add') || str_contains($categoryNameEn, 'extra') => 'https://images.unsplash.com/photo-1511381939415-e44015466834?q=80&w=800&auto=format&fit=crop',
                        str_contains($categoryName, 'شيش') || str_contains($categoryNameEn, 'shisha') || str_contains($categoryNameEn, 'hookah') => 'https://imgg.io/images/2026/05/26/9f0a99a13f0fea779a7f8582d22519c9.jpg',
                        default => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=800&auto=format&fit=crop'
                    };
                    
                    $bgImage = $firstItem?->image_path ? asset('storage/'.$firstItem->image_path) : $matchedImage;
                @endphp
                
                <section class="category-section" id="cat-{{ $category->id }}" data-category-name="{{ $category->name_ar }}">
                    <!-- Category Banner -->
                    <div class="category-banner">
                        <div class="category-bg" style="background-image: url('{{ $bgImage }}');"></div>
                        <div class="category-overlay"></div>
                        <div class="category-title-wrap">
                            <h2 class="category-title-ar">{{ $category->name_ar }}</h2>
                            <span class="category-title-en">{{ strtoupper($category->name_en ?? $category->name_ar) }}</span>
                        </div>
                    </div>

                    <!-- Products List -->
                    <div class="products-list">
                        @foreach($category->products as $item)
                            @php
                                $nameParts = explode('/', $item->name);
                                $arabicName = trim($nameParts[0]);
                                $englishName = isset($nameParts[1]) ? trim($nameParts[1]) : '';
                            @endphp
                            <div class="product-item" id="osirix-product-{{ $item->id }}" data-product-name="{{ $item->name }}" data-product-desc="{{ $item->description }}" data-product-price="{{ number_format($item->displayPrice(), 2) }} ج.م" data-product-image="">
                                <div class="product-details">
                                    <h4 class="product-name-ar">{{ $arabicName }}</h4>
                                    @if($englishName)
                                        <span class="product-name-en" style="font-family: 'Outfit', sans-serif; font-size: 0.85rem; color: var(--gold); font-weight: 500; display: block; margin-top: 2px;">{{ $englishName }}</span>
                                    @endif
                                    @if($item->description)
                                        <p class="product-desc">{{ $item->description }}</p>
                                    @endif
                                </div>
                                
                                <div class="product-price-box">
                                    <span class="product-price">@include('menu.partials.product-price', ['product' => $item, 'decimals' => 0])</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
    </div>

    <!-- SERVICE CHARGE NOTE -->
    <div class="service-charge-note" style="text-align: center; margin: 45px auto 25px; display: flex; align-items: center; justify-content: center; gap: 15px; max-width: 320px;">
        <div style="flex: 1; height: 1px; background: linear-gradient(to left, rgba(212, 175, 55, 0.3), transparent);"></div>
        <span style="font-size: 0.88rem; color: var(--gold); font-weight: 600; display: inline-flex; align-items: center; gap: 6px; font-family: 'Cairo', sans-serif; letter-spacing: 0.5px;">
            <i class="fa-solid fa-asterisk" style="font-size: 0.65rem; opacity: 0.8;"></i>
            يضاف 12% خدمة
        </span>
        <div style="flex: 1; height: 1px; background: linear-gradient(to right, rgba(212, 175, 55, 0.3), transparent);"></div>
    </div>

</div>

<!-- FLOATING FOOTER NAVIGATION -->
<nav class="footer-nav-bar" aria-label="التصنيفات">
    @foreach($categories as $category)
        @if($category->products->count())
            <a href="#cat-{{ $category->id }}" class="footer-nav-item">
                {{ $category->name_ar }}
            </a>
        @endif
    @endforeach
</nav>

@include('menu.partials.ai-assistant')

<script>
    // Theme Toggle Functionality
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    const themeIcon = themeToggle.querySelector('i');

    // Load saved theme
    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light-theme');
        themeIcon.className = 'fa-solid fa-sun';
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('light-theme');
        if (body.classList.contains('light-theme')) {
            themeIcon.className = 'fa-solid fa-sun';
            localStorage.setItem('theme', 'light');
        } else {
            themeIcon.className = 'fa-solid fa-moon';
            localStorage.setItem('theme', 'dark');
        }
    });

    // Search Filtering Functionality
    const searchInput = document.getElementById('searchInput');
    const productItems = document.querySelectorAll('.product-item');
    const categorySections = document.querySelectorAll('.category-section');
    const emptySearch = document.getElementById('emptySearch');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        let anyMatch = false;

        categorySections.forEach(section => {
            let sectionHasMatch = false;
            const items = section.querySelectorAll('.product-item');
            
            items.forEach(item => {
                const name = item.getAttribute('data-product-name').toLowerCase();
                const desc = (item.getAttribute('data-product-desc') || '').toLowerCase();
                
                if (name.includes(query) || desc.includes(query)) {
                    item.style.display = 'grid';
                    sectionHasMatch = true;
                    anyMatch = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (sectionHasMatch) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });

        if (anyMatch || query === '') {
            emptySearch.style.display = 'none';
        } else {
            emptySearch.style.display = 'block';
        }
    });



    // Handle Active Scroll Category Highlight
    const navItems = document.querySelectorAll('.footer-nav-item');
    
    window.addEventListener('scroll', () => {
        let current = '';
        
        categorySections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= (sectionTop - 120)) {
                current = section.getAttribute('id');
            }
        });

        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${current}`) {
                item.classList.add('active');
                
                // Auto scroll categories bar to active category
                item.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        });
    });
</script>
</body>
</html>
