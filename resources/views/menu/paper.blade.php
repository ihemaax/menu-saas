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
    
    <!-- Google Fonts: Amiri for classic Arabic, Cinzel for premium vintage headers, Cairo & Outfit for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cinzel:wght@400;500;600;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Dark Paper Palette */
            --bg-color-dark: #110e0c;
            --bg-gradient-dark: radial-gradient(circle at center, #1b1613 0%, #0d0a09 100%);
            --paper-card-bg-dark: rgba(22, 19, 17, 0.75);
            --gold-accent: #c5a059;
            --gold-accent-hover: #e3be7b;
            --gold-accent-glow: rgba(197, 160, 89, 0.2);
            --text-primary-dark: #ece6dc;
            --text-secondary-dark: #8a7f72;
            --border-primary-dark: rgba(197, 160, 89, 0.35);
            --border-dashed-dark: rgba(197, 160, 89, 0.18);
            --shadow-color-dark: rgba(0, 0, 0, 0.7);

            /* Light Paper Palette */
            --bg-color-light: #f5f1e6;
            --bg-gradient-light: radial-gradient(circle at center, #faf8f2 0%, #ebe5d5 100%);
            --paper-card-bg-light: rgba(24bf, 246, 238, 0.85); /* fallback translucent white-beige */
            --text-primary-light: #2b231d;
            --text-secondary-light: #6e6153;
            --border-primary-light: rgba(163, 125, 55, 0.45);
            --border-dashed-light: rgba(163, 125, 55, 0.22);
            --shadow-color-light: rgba(43, 35, 29, 0.15);

            /* Active Theme Variables */
            --bg-color: var(--bg-color-dark);
            --bg-gradient: var(--bg-gradient-dark);
            --paper-card-bg: var(--paper-card-bg-dark);
            --text-primary: var(--text-primary-dark);
            --text-secondary: var(--text-secondary-dark);
            --border-primary: var(--border-primary-dark);
            --border-dashed: var(--border-dashed-dark);
            --shadow-color: var(--shadow-color-dark);
        }

        body.light-theme {
            --bg-color: var(--bg-color-light);
            --bg-gradient: var(--bg-gradient-light);
            --paper-card-bg: rgba(250, 247, 240, 0.85);
            --text-primary: var(--text-primary-light);
            --text-secondary: var(--text-secondary-light);
            --border-primary: var(--border-primary-light);
            --border-dashed: var(--border-dashed-light);
            --shadow-color: var(--shadow-color-light);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        body {
            font-family: 'Cairo', 'Amiri', 'Outfit', sans-serif;
            background: var(--bg-gradient);
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            padding-bottom: 120px;
            overflow-x: hidden;
            position: relative;
        }

        /* Tactical Paper/Leather Grain Noise Overlay */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            opacity: 0.035;
            pointer-events: none;
            z-index: 9999;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }

        body.light-theme::before {
            opacity: 0.055;
        }

        /* Outer Vintage Ornate Frame */
        .outer-frame {
            position: relative;
            max-width: 960px;
            margin: 24px auto;
            padding: 32px 24px;
            border: 3px double var(--gold-accent);
            outline: 1px solid var(--gold-accent);
            outline-offset: -8px;
            box-shadow: 0 20px 50px var(--shadow-color);
            background: var(--paper-card-bg);
            border-radius: 4px;
        }

        @media (max-width: 640px) {
            .outer-frame {
                margin: 12px;
                padding: 24px 14px;
                outline-offset: -6px;
            }
        }

        /* Ornate Corner SVG Elements */
        .corner-ornament {
            position: absolute;
            width: 44px;
            height: 44px;
            pointer-events: none;
            z-index: 10;
        }

        .corner-ornament svg {
            width: 100%;
            height: 100%;
        }

        .corner-ornament svg path, .corner-ornament svg circle {
            stroke: var(--gold-accent);
            fill: none;
        }

        .corner-ornament svg circle {
            fill: var(--gold-accent);
        }

        .top-left {
            top: 10px;
            left: 10px;
            transform: scaleX(-1);
        }

        .top-right {
            top: 10px;
            right: 10px;
        }

        .bottom-left {
            bottom: 10px;
            left: 10px;
            transform: scale(-1);
        }

        .bottom-right {
            bottom: 10px;
            right: 10px;
            transform: scaleY(-1);
        }

        /* Header Layout */
        header {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-dashed);
        }

        /* Shield logo container */
        .logo-shield-container {
            position: relative;
            width: 130px;
            height: 150px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            filter: drop-shadow(0 10px 25px var(--shadow-color));
        }

        .logo-shield-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .logo-shield-svg path {
            fill: var(--bg-color);
            stroke: var(--gold-accent);
            transition: fill 0.3s ease, stroke 0.3s ease;
        }

        .logo-image-wrapper {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 25px; /* leave room for shield pointy bottom */
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo-image-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Full logo visible without lopsided cropping */
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.5));
            border-radius: 50%; /* Crop the white corners of the square image */
            background: #000; /* Match their circular logo's black background */
        }

        .logo-text-fallback {
            font-family: 'Cinzel', serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--gold-accent);
            text-shadow: 0 2px 4px var(--shadow-color);
        }

        .brand-name {
            font-family: 'Cinzel', 'Amiri', serif;
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--text-primary);
            text-shadow: 0 2px 4px var(--shadow-color);
            line-height: 1.25;
            margin-top: 8px;
            letter-spacing: 1px;
        }

        .brand-subname {
            font-family: 'Cinzel', 'Outfit', sans-serif;
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--gold-accent);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 12px;
            text-shadow: 0 2px 4px var(--shadow-color);
        }

        .brand-tagline {
            font-family: 'Cinzel', 'Outfit', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gold-accent);
            text-transform: uppercase;
            letter-spacing: 0.22em;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-tagline::before, .brand-tagline::after {
            content: "";
            display: inline-block;
            width: 24px;
            height: 1px;
            background: var(--gold-accent);
        }

        .brand-desc {
            font-family: 'Amiri', 'Cairo', sans-serif;
            font-size: 0.95rem;
            color: var(--text-secondary);
            max-width: 500px;
            margin-top: 12px;
            line-height: 1.6;
        }

        .brand-desc-en {
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            color: var(--text-secondary);
            max-width: 500px;
            margin-top: 4px;
            line-height: 1.5;
            letter-spacing: 0.5px;
        }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            position: absolute;
            top: 0;
            left: 0;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid var(--border-primary);
            background: rgba(197, 160, 89, 0.08);
            color: var(--gold-accent);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px var(--shadow-color);
            z-index: 20;
        }

        .theme-toggle-btn:hover {
            transform: scale(1.05);
            background: rgba(197, 160, 89, 0.16);
            box-shadow: 0 0 12px var(--gold-accent-glow);
        }

        /* Search Bar styling */
        .search-container {
            position: relative;
            max-width: 480px;
            margin: 0 auto 35px;
        }

        .search-input {
            width: 100%;
            padding: 13px 45px 13px 20px;
            border-radius: 4px;
            border: 1px solid var(--border-primary);
            background: rgba(22, 19, 17, 0.25);
            color: var(--text-primary);
            font-family: 'Cairo', sans-serif;
            font-size: 0.95rem;
            outline: none;
            text-align: right;
            box-shadow: inset 0 2px 4px var(--shadow-color);
        }

        body.light-theme .search-input {
            background: rgba(255, 255, 255, 0.4);
        }

        .search-input:focus {
            border-color: var(--gold-accent);
            box-shadow: 0 0 8px var(--gold-accent-glow), inset 0 2px 4px var(--shadow-color);
        }

        .search-icon {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            color: var(--gold-accent);
            font-size: 1rem;
        }

        /* Menu layout grid */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        @media (max-width: 900px) {
            .categories-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        /* Category Card Frame */
        .category-card {
            background: rgba(22, 19, 17, 0.2);
            border: 1px solid var(--border-primary);
            border-radius: 4px;
            padding: 24px 20px;
            position: relative;
            box-shadow: 0 8px 24px var(--shadow-color);
            scroll-margin-top: 120px;
            display: flex;
            flex-direction: column;
        }

        body.light-theme .category-card {
            background: rgba(255, 255, 255, 0.25);
        }

        .category-card::before {
            content: "";
            position: absolute;
            inset: 4px;
            border: 1px dashed var(--border-dashed);
            border-radius: 2px;
            pointer-events: none;
        }

        /* Category Card Header */
        .category-header {
            text-align: center;
            margin-bottom: 22px;
            position: relative;
            padding-bottom: 12px;
        }

        .category-title {
            font-family: 'Cinzel', 'Amiri', serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--gold-accent);
            text-shadow: 0 1px 3px var(--shadow-color);
            letter-spacing: 1px;
            line-height: 1.3;
        }

        /* Decorative flourishes under category name */
        .category-header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 10px;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 10' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 5 L35 5 L40 2 L45 8 L50 2 L55 8 L60 2 L65 5 L100 5' stroke='%23c5a059' stroke-width='1.5' fill='none'/%3E%3Ccircle cx='50' cy='5' r='1.8' fill='%23c5a059'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        body.light-theme .category-header::after {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 10' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 5 L35 5 L40 2 L45 8 L50 2 L55 8 L60 2 L65 5 L100 5' stroke='%23a37d37' stroke-width='1.5' fill='none'/%3E%3Ccircle cx='50' cy='5' r='1.8' fill='%23a37d37'/%3E%3C/svg%3E");
        }

        /* Products Listing */
        .products-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            z-index: 5;
        }

        .product-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }

        .product-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
            width: 100%;
        }

        .product-name-wrap {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .product-title-ar {
            font-family: 'Cairo', 'Amiri', sans-serif;
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1.05rem;
            line-height: 1.4;
        }

        .product-title-en {
            font-family: 'Outfit', sans-serif;
            font-size: 0.82rem;
            color: var(--gold-accent);
            font-weight: 500;
            margin-top: 1px;
            letter-spacing: 0.5px;
        }

        /* Dotted Leader Line styling */
        .product-leader {
            flex: 1;
            border-bottom: 1.5px dotted var(--border-dashed);
            margin: 0 4px;
            height: 1px;
            align-self: center;
        }

        .product-price-box {
            font-family: 'Cinzel', 'Outfit', serif;
            font-weight: 700;
            color: var(--gold-accent);
            font-size: 1.1rem;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .product-desc {
            font-family: 'Cairo', 'Amiri', sans-serif;
            font-size: 0.82rem;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-top: 4px;
            text-align: right;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Optional Thumbnail Container if image exists */
        .product-row-flex {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .product-info-col {
            flex: 1;
            min-width: 0;
        }

        .product-thumbnail {
            width: 65px;
            height: 65px;
            border-radius: 4px;
            border: 1px solid var(--border-primary);
            padding: 2px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 4px 10px var(--shadow-color);
            background: rgba(22,19,17,0.4);
        }

        /* Empty search state */
        .empty-search-state {
            display: none;
            text-align: center;
            padding: 50px 20px;
            grid-column: 1 / -1;
            color: var(--text-secondary);
            font-family: 'Cairo', sans-serif;
        }

        .empty-search-state i {
            font-size: 2.8rem;
            color: var(--gold-accent);
            margin-bottom: 16px;
            opacity: 0.7;
        }

        .empty-search-state p {
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Floating footer navigation bar */
        .footer-nav-bar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 32px);
            max-width: 520px;
            background: rgba(17, 14, 12, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--border-primary);
            border-radius: 4px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            z-index: 100;
            box-shadow: 0 10px 30px var(--shadow-color);
            scrollbar-width: none; /* Firefox */
        }

        body.light-theme .footer-nav-bar {
            background: rgba(245, 241, 230, 0.9);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .footer-nav-bar::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }

        .footer-nav-item {
            flex: 0 0 auto;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 2px;
            color: var(--text-primary);
            font-size: 0.85rem;
            font-weight: 700;
            background: transparent;
            border: 1px solid transparent;
            white-space: nowrap;
            font-family: 'Cairo', sans-serif;
            transition: all 0.2s ease;
        }

        .footer-nav-item.active, .footer-nav-item:hover {
            background: rgba(197, 160, 89, 0.12);
            color: var(--gold-accent);
            border-color: var(--border-primary);
        }

        /* Modal Overlay for details */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
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
            max-width: 440px;
            background: var(--bg-color);
            border: 2px solid var(--border-primary);
            border-radius: 4px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.65);
            transform: scale(0.92);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s;
            position: relative;
            padding: 24px;
        }

        .modal-card::before {
            content: "";
            position: absolute;
            inset: 4px;
            border: 1px dashed var(--border-dashed);
            pointer-events: none;
        }

        .modal-overlay.open .modal-card {
            transform: scale(1);
        }

        .modal-close-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 32px;
            height: 32px;
            border: 1px solid var(--border-primary);
            background: rgba(22, 19, 17, 0.5);
            color: var(--gold-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .modal-close-btn:hover {
            background: var(--gold-accent);
            color: var(--bg-color);
        }

        .modal-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border: 1px solid var(--border-primary);
            margin-bottom: 18px;
            box-shadow: 0 6px 15px var(--shadow-color);
            background: rgba(22,19,17,0.3);
        }

        .modal-body {
            text-align: right;
        }

        .modal-title-ar {
            font-family: 'Cairo', 'Amiri', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .modal-title-en {
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            color: var(--gold-accent);
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .modal-price {
            font-family: 'Cinzel', 'Outfit', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--gold-accent);
            margin-bottom: 16px;
            display: inline-block;
            border-bottom: 2px solid var(--gold-accent);
            padding-bottom: 4px;
        }

        .modal-desc {
            font-family: 'Cairo', sans-serif;
            font-size: 0.92rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Bottom Credit styling matching theme */
        .menu-credit-wrapper {
            margin-top: 45px;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
        }

        .menu-credit-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: rgba(197, 160, 89, 0.04);
            border: 1px solid var(--border-dashed);
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .menu-credit-badge:hover {
            border-color: var(--border-primary);
            color: var(--gold-accent);
            background: rgba(197, 160, 89, 0.1);
        }

        .menu-credit-badge span {
            color: var(--gold-accent);
            font-weight: 700;
        }

        /* Ornate dividers on top and bottom of outer frame */
        .frame-ornament-center {
            display: flex;
            justify-content: center;
            margin: 10px 0;
            color: var(--gold-accent);
        }

        .frame-ornament-center svg {
            width: 80px;
            height: 16px;
            fill: var(--gold-accent);
        }

        /* Barber Shop Background Watermarks (Inside Menu Frame) */
        .frame-watermark {
            position: absolute;
            color: var(--gold-accent);
            opacity: 0.035; /* Faintly visible behind text */
            pointer-events: none;
            z-index: 1; /* Behind product text */
        }

        body.light-theme .frame-watermark {
            opacity: 0.06; /* slightly more visible on light paper background */
        }

        .frame-watermark svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            stroke-width: 1.2px;
            fill: none;
        }

        /* Centered Header Watermark */
        .header-watermark {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            opacity: 0.03;
            pointer-events: none;
            z-index: 1;
        }
        
        body.light-theme .header-watermark {
            opacity: 0.055;
        }

        .header-watermark svg {
            width: 100%;
            height: 100%;
        }

        /* Specific scroll positions for watermarks down the menu frame */
        .wm-scissors-left {
            top: 10%;
            left: 3%;
            width: 130px;
            height: 130px;
            transform: rotate(-25deg);
        }

        .wm-pole-right {
            top: 25%;
            right: 4%;
            width: 75px;
            height: 170px;
            transform: rotate(12deg);
        }

        .wm-razor-left {
            top: 45%;
            left: 2%;
            width: 120px;
            height: 120px;
            transform: rotate(45deg);
        }

        .wm-comb-right {
            top: 62%;
            right: 3%;
            width: 140px;
            height: 58px;
            transform: rotate(-15deg);
        }

        .wm-dryer-left {
            top: 78%;
            left: 4%;
            width: 120px;
            height: 120px;
            transform: rotate(30deg);
        }

        .wm-scissors-right {
            top: 91%;
            right: 4%;
            width: 120px;
            height: 120px;
            transform: rotate(15deg);
        }

        @media (max-width: 768px) {
            .frame-watermark {
                opacity: 0.02;
                width: 90px !important;
                height: 90px !important;
            }
            .wm-pole-right {
                width: 55px !important;
                height: 125px !important;
            }
            .wm-comb-right {
                width: 100px !important;
                height: 42px !important;
            }
            .header-watermark {
                width: 180px !important;
                height: 180px !important;
                top: 60%;
            }
            body.light-theme .frame-watermark {
                opacity: 0.035;
            }
        }

        /* Branches & Contact Section */
        .branches-contact-section {
            margin-top: 45px;
            padding: 30px 20px 10px;
            border-top: 1px solid var(--border-dashed);
            position: relative;
            z-index: 5;
            text-align: center;
        }

        .branches-header {
            margin-bottom: 30px;
        }

        .branches-title {
            font-family: 'Amiri', 'Cairo', serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--gold-accent);
            text-shadow: 0 1px 3px var(--shadow-color);
            margin-bottom: 6px;
        }

        .branches-subtitle {
            font-family: 'Cairo', sans-serif;
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .branches-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }

        @media (max-width: 768px) {
            .branches-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        .branch-card {
            background: rgba(22, 19, 17, 0.15);
            border: 1px solid var(--border-primary);
            border-radius: 4px;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            text-decoration: none;
        }

        body.light-theme .branch-card {
            background: rgba(255, 255, 255, 0.2);
        }

        .branch-card::before {
            content: "";
            position: absolute;
            inset: 4px;
            border: 1px dashed var(--border-dashed);
            border-radius: 2px;
            pointer-events: none;
        }

        .branch-card:hover {
            transform: translateY(-3px);
            background: rgba(197, 160, 89, 0.05);
            box-shadow: 0 8px 24px var(--shadow-color);
        }

        body.light-theme .branch-card:hover {
            background: rgba(163, 125, 55, 0.05);
        }

        .branch-icon {
            font-size: 1.3rem;
            color: var(--gold-accent);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 1px solid var(--border-primary);
            background: rgba(22, 19, 17, 0.4);
            box-shadow: 0 4px 10px var(--shadow-color);
        }

        body.light-theme .branch-icon {
            background: rgba(255, 255, 255, 0.5);
        }

        .branch-name {
            font-family: 'Amiri', 'Cairo', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gold-accent);
            margin-bottom: 8px;
        }

        .branch-address {
            font-family: 'Cairo', sans-serif;
            font-size: 0.88rem;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .contact-action-wrapper {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        @media (max-width: 580px) {
            .contact-action-wrapper {
                flex-direction: column;
                align-items: center;
                gap: 14px;
            }
        }

        .contact-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 12px 28px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px var(--shadow-color);
            min-width: 260px;
            text-align: right;
            box-sizing: border-box;
        }

        @media (max-width: 580px) {
            .contact-action-btn {
                width: 100%;
                max-width: 320px;
            }
        }

        .contact-action-btn i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .btn-text-content {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .btn-lbl {
            font-family: 'Cairo', sans-serif;
            font-size: 0.75rem;
            opacity: 0.85;
            font-weight: 600;
        }

        .btn-val {
            font-family: 'Outfit', 'Cairo', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .btn-call {
            background: rgba(197, 160, 89, 0.08);
            border: 1px solid var(--gold-accent);
            color: var(--gold-accent);
        }

        .btn-call:hover {
            background: var(--gold-accent);
            color: var(--bg-color-dark);
            transform: translateY(-2px);
            box-shadow: 0 0 15px var(--gold-accent-glow);
        }

        body.light-theme .btn-call:hover {
            color: var(--bg-color-light);
        }

        .btn-whatsapp {
            background: rgba(37, 211, 102, 0.08);
            border: 1px solid #25d366;
            color: #25d366;
        }

        .btn-whatsapp:hover {
            background: #25d366;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.25);
        }

        /* Social Media Icons */
        .social-media-wrapper {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .social-icon-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 1px solid var(--border-primary);
            background: rgba(22, 19, 17, 0.3);
            color: var(--gold-accent);
            font-size: 1.25rem;
            text-decoration: none;
            box-shadow: 0 4px 10px var(--shadow-color);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        body.light-theme .social-icon-link {
            background: rgba(255, 255, 255, 0.5);
        }

        .social-icon-link::before {
            content: "";
            position: absolute;
            inset: 3px;
            border: 1px dashed var(--border-dashed);
            border-radius: 50%;
            pointer-events: none;
            transition: border-color 0.3s ease;
        }

        .social-icon-link:hover {
            transform: translateY(-4px) scale(1.08);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 8px 20px var(--shadow-color);
        }

        /* Specific Brand Hover Colors */
        .social-icon-link.tiktok-link:hover {
            background: #000000;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
        }
        
        .social-icon-link.instagram-link:hover {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285aeb 90%);
            box-shadow: 0 0 15px rgba(214, 36, 159, 0.4);
        }

        .social-icon-link.facebook-link:hover {
            background: #1877f2;
            box-shadow: 0 0 15px rgba(24, 119, 242, 0.4);
        }

        .social-icon-link.snapchat-link:hover {
            background: #fffc00;
            color: #000000;
            box-shadow: 0 0 15px rgba(255, 252, 0, 0.4);
        }

        .social-icon-link.youtube-link:hover {
            background: #ff0000;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
        }

        .social-icon-link:hover::before {
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Floating Social Button & Popover */
        .floating-social-container {
            position: fixed;
            bottom: 85px; /* Stay clear of footer nav bar on mobile */
            right: 24px;
            z-index: 999;
            direction: ltr; /* keep icons layout consistent */
        }

        .fab-button {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1b1613 0%, #0d0a09 100%);
            border: 2px solid var(--gold-accent);
            color: var(--gold-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            cursor: pointer;
            box-shadow: 0 8px 25px var(--shadow-color);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        body.light-theme .fab-button {
            background: linear-gradient(135deg, #faf8f2 0%, #ebe5d5 100%);
        }

        .fab-button::before {
            content: "";
            position: absolute;
            inset: 3px;
            border: 1px dashed var(--border-dashed);
            border-radius: 50%;
            pointer-events: none;
        }

        @keyframes fab-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(197, 160, 89, 0.5), 0 8px 25px var(--shadow-color);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(197, 160, 89, 0), 0 8px 25px var(--shadow-color);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(197, 160, 89, 0), 0 8px 25px var(--shadow-color);
            }
        }

        @keyframes fab-pulse-light {
            0% {
                box-shadow: 0 0 0 0 rgba(163, 125, 55, 0.4), 0 8px 25px var(--shadow-color);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(163, 125, 55, 0), 0 8px 25px var(--shadow-color);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(163, 125, 55, 0), 0 8px 25px var(--shadow-color);
            }
        }

        .fab-button:not(.active) {
            animation: fab-pulse 2s infinite;
        }

        body.light-theme .fab-button:not(.active) {
            animation: fab-pulse-light 2s infinite;
        }

        .fab-button:hover {
            transform: scale(1.08);
            color: var(--gold-accent-hover);
        }

        .fab-button.active {
            transform: scale(0.95);
            background: var(--gold-accent);
            color: #110e0c;
            animation: none;
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        body.light-theme .fab-button.active {
            color: #faf8f2;
        }

        .fab-button.active::before {
            border-color: rgba(0, 0, 0, 0.2);
        }

        body.light-theme .fab-button.active::before {
            border-color: rgba(255, 255, 255, 0.4);
        }

        /* Default and Active Icon state transitions */
        .fab-icon-default,
        .fab-icon-active {
            position: absolute;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .fab-icon-default {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        .fab-icon-active {
            opacity: 0;
            transform: scale(0) rotate(-90deg);
        }

        .fab-button.active .fab-icon-default {
            opacity: 0;
            transform: scale(0) rotate(90deg);
        }

        .fab-button.active .fab-icon-active {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        /* Popover Menu Card */
        .social-popover-menu {
            position: absolute;
            bottom: 72px;
            right: 0;
            width: 280px;
            background: rgba(17, 14, 12, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 2px solid var(--border-primary);
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 15px 35px var(--shadow-color);
            transform: scale(0.8) translateY(15px);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform-origin: bottom right;
        }

        body.light-theme .social-popover-menu {
            background: rgba(245, 241, 230, 0.92);
        }

        .social-popover-menu.open {
            transform: scale(1) translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        .social-popover-menu::before {
            content: "";
            position: absolute;
            inset: 4px;
            border: 1px dashed var(--border-dashed);
            border-radius: 4px;
            pointer-events: none;
        }

        .popover-header {
            text-align: center;
            font-family: 'Amiri', 'Cairo', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gold-accent);
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--border-dashed);
            direction: rtl;
        }

        .popover-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }

        .popover-link {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            border-radius: 4px;
            border: 1px solid var(--border-primary);
            background: rgba(22, 19, 17, 0.4);
            color: var(--text-primary);
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        body.light-theme .popover-link {
            background: rgba(255, 255, 255, 0.6);
        }

        .popover-link:hover {
            transform: translateY(-2px);
            color: #ffffff;
        }

        /* Hover colors matching brands */
        .popover-link.tiktok-link:hover { background-color: #000000; border-color: #000000; }
        .popover-link.instagram-link:hover { background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285aeb 90%); border-color: transparent; }
        .popover-link.facebook-link:hover { background-color: #1877f2; border-color: #1877f2; }
        .popover-link.snapchat-link:hover { background-color: #fffc00; border-color: #fffc00; color: #000000; }
        .popover-link.youtube-link:hover { background-color: #ff0000; border-color: #ff0000; }

        /* Popover Direct Contact Buttons */
        .popover-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .popover-action-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-family: 'Cairo', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            transition: all 0.2s ease;
            direction: rtl;
        }

        .popover-action-btn i {
            font-size: 1.1rem;
        }

        .popover-action-btn.btn-call {
            background: rgba(197, 160, 89, 0.08);
            border: 1px solid var(--gold-accent);
            color: var(--gold-accent);
        }

        .popover-action-btn.btn-call:hover {
            background: var(--gold-accent);
            color: var(--bg-color-dark);
        }

        body.light-theme .popover-action-btn.btn-call:hover {
            color: var(--bg-color-light);
        }

        .popover-action-btn.btn-whatsapp {
            background: rgba(37, 211, 102, 0.08);
            border: 1px solid #25d366;
            color: #25d366;
        }

        .popover-action-btn.btn-whatsapp:hover {
            background: #25d366;
            color: #ffffff;
        }

    </style>
</head>
<body>

@php
    $allItemsCount = $categories->sum(fn($category) => $category->products->count());

    // Split restaurant name (e.g., "صالون النرويجي     El-Nerwegy Barber Shop")
    $name = $restaurant->name;
    $nameParts = [];
    if (str_contains($name, '/')) {
        $nameParts = explode('/', $name);
    } elseif (preg_match('/\s{2,}/', $name)) {
        $nameParts = preg_split('/\s{2,}/', $name);
    } elseif (str_contains($name, ' - ')) {
        $nameParts = explode(' - ', $name);
    } else {
        $nameParts = [$name];
    }
    
    $arabicName = trim($nameParts[0]);
    $englishName = isset($nameParts[1]) ? trim($nameParts[1]) : '';
    
    // Split restaurant description (e.g. "أرقى خدمات العناية بالشعر والوجه والبشرة للرجال والسيدات / Premium Hair, Face & Skin Care Services")
    $desc = $restaurant->description;
    $arabicDesc = '';
    $englishDesc = '';
    
    if ($desc) {
        $descParts = [];
        if (str_contains($desc, '/')) {
            $descParts = explode('/', $desc);
        } elseif (str_contains($desc, ' - ')) {
            $descParts = explode(' - ', $desc);
        } elseif (preg_match('/\s{2,}/', $desc)) {
            $descParts = preg_split('/\s{2,}/', $desc);
        } else {
            $descParts = [$desc];
        }
        
        $hasArabic = function($str) {
            return preg_match('/\p{Arabic}/u', $str);
        };
        
        if (count($descParts) > 1) {
            $part1 = trim($descParts[0]);
            $part2 = trim($descParts[1]);
            if ($hasArabic($part1)) {
                $arabicDesc = $part1;
                $englishDesc = $part2;
            } else {
                $arabicDesc = $part2;
                $englishDesc = $part1;
            }
        } else {
            $part = trim($descParts[0]);
            if ($hasArabic($part)) {
                $arabicDesc = $part;
            } else {
                $englishDesc = $part;
            }
        }
    }
@endphp

<div class="outer-frame">
    <!-- Ornate Corners -->
    <div class="corner-ornament top-left">
        <svg viewBox="0 0 100 100">
            <path d="M 0,0 L 50,0 Q 15,15 15,50 L 15,100" />
            <path d="M 0,0 L 0,50 Q 15,15 50,15 L 100,15" />
            <path d="M 8,8 Q 30,8 30,30 Q 30,45 20,40 Q 15,35 22,25 Q 28,15 15,15" />
            <circle cx="20" cy="20" r="3" />
        </svg>
    </div>
    <div class="corner-ornament top-right">
        <svg viewBox="0 0 100 100">
            <path d="M 0,0 L 50,0 Q 15,15 15,50 L 15,100" />
            <path d="M 0,0 L 0,50 Q 15,15 50,15 L 100,15" />
            <path d="M 8,8 Q 30,8 30,30 Q 30,45 20,40 Q 15,35 22,25 Q 28,15 15,15" />
            <circle cx="20" cy="20" r="3" />
        </svg>
    </div>
    <div class="corner-ornament bottom-left">
        <svg viewBox="0 0 100 100">
            <path d="M 0,0 L 50,0 Q 15,15 15,50 L 15,100" />
            <path d="M 0,0 L 0,50 Q 15,15 50,15 L 100,15" />
            <path d="M 8,8 Q 30,8 30,30 Q 30,45 20,40 Q 15,35 22,25 Q 28,15 15,15" />
            <circle cx="20" cy="20" r="3" />
        </svg>
    </div>
    <div class="corner-ornament bottom-right">
        <svg viewBox="0 0 100 100">
            <path d="M 0,0 L 50,0 Q 15,15 15,50 L 15,100" />
            <path d="M 0,0 L 0,50 Q 15,15 50,15 L 100,15" />
            <path d="M 8,8 Q 30,8 30,30 Q 30,45 20,40 Q 15,35 22,25 Q 28,15 15,15" />
            <circle cx="20" cy="20" r="3" />
        </svg>
    </div>

    <!-- Faint Barber Shop watermark illustrations directly inside the menu card (behind text) -->
    <div class="frame-watermark wm-scissors-left">
        <svg viewBox="0 0 100 100">
            <circle cx="35" cy="75" r="12" stroke-width="1.5" />
            <circle cx="65" cy="75" r="12" stroke-width="1.5" />
            <path d="M 35,63 L 46,50 L 80,10" stroke-width="1.5" stroke-linecap="round" />
            <path d="M 65,63 L 54,50 L 20,10" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="50" cy="50" r="2.5" fill="var(--gold-accent)" />
        </svg>
    </div>

    <div class="frame-watermark wm-pole-right">
        <svg viewBox="0 0 60 140">
            <path d="M 12,30 L 20,30 M 12,110 L 20,110" stroke-width="2" />
            <rect x="20" y="25" width="20" height="90" rx="3" stroke-width="1.5" />
            <circle cx="30" cy="14" r="10" stroke-width="1.5" />
            <path d="M 22,115 L 38,115 L 30,128 Z" stroke-width="1.5" />
            <path d="M 20,35 L 40,48 M 20,53 L 40,66 M 20,71 L 40,84 M 20,89 L 40,102 M 20,107 L 40,120" stroke-width="1.5" />
        </svg>
    </div>

    <div class="frame-watermark wm-razor-left">
        <svg viewBox="0 0 100 100">
            <path d="M 15,85 C 30,80 40,65 45,45 C 47,35 48,25 45,15" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="45" cy="45" r="3" fill="var(--gold-accent)" />
            <path d="M 45,45 Q 60,50 82,40 C 88,35 88,28 82,23 C 60,28 45,35 45,45 Z" stroke-width="1.5" stroke-linecap="round" />
        </svg>
    </div>

    <div class="frame-watermark wm-comb-right">
        <svg viewBox="0 0 140 50">
            <path d="M 5,12 L 135,12 C 138,12 138,18 135,18 L 5,18 Z" stroke-width="1.5" />
            <path d="M 10,18 L 10,42 M 16,18 L 16,42 M 22,18 L 22,42 M 28,18 L 28,42 M 34,18 L 34,42 M 40,18 L 40,42 M 46,18 L 46,42 M 52,18 L 52,42 M 58,18 L 58,42 M 64,18 L 64,42 M 70,18 L 70,42 M 76,18 L 76,42 M 82,18 L 82,42 M 88,18 L 88,42 M 94,18 L 94,42 M 100,18 L 100,42 M 106,18 L 106,42 M 112,18 L 112,42 M 118,18 L 118,42 M 124,18 L 124,42 M 130,18 L 130,42" stroke-width="1" />
        </svg>
    </div>

    <div class="frame-watermark wm-dryer-left">
        <svg viewBox="0 0 100 100">
            <path d="M 25,20 L 60,20 Q 75,20 75,35 Q 75,45 65,48 L 45,52 L 45,80 Q 45,85 40,85 Q 35,85 35,80 L 35,52 Z" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M 25,15 L 25,45" stroke-width="2" stroke-linecap="round" />
            <path d="M 50,52 L 50,80" stroke-width="1" stroke-dasharray="2,2" />
            <path d="M 82,25 Q 87,27 92,25 M 84,32 Q 89,34 94,32 M 82,40 Q 87,42 92,40" stroke-width="1" stroke-linecap="round" />
        </svg>
    </div>

    <div class="frame-watermark wm-scissors-right">
        <svg viewBox="0 0 100 100">
            <circle cx="35" cy="75" r="12" stroke-width="1.5" />
            <circle cx="65" cy="75" r="12" stroke-width="1.5" />
            <path d="M 35,63 L 46,50 L 80,10" stroke-width="1.5" stroke-linecap="round" />
            <path d="M 65,63 L 54,50 L 20,10" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="50" cy="50" r="2.5" fill="var(--gold-accent)" />
        </svg>
    </div>

    <!-- HEADER -->
    <header>
        <!-- Faint crossed scissors and comb watermark directly centered behind header text -->
        <div class="header-watermark">
            <svg viewBox="0 0 100 100">
                <!-- Scissors -->
                <circle cx="33" cy="70" r="10" stroke="var(--gold-accent)" stroke-width="1.3" fill="none" />
                <circle cx="67" cy="70" r="10" stroke="var(--gold-accent)" stroke-width="1.3" fill="none" />
                <path d="M 33,60 L 45,45 L 78,12" stroke="var(--gold-accent)" stroke-width="1.3" stroke-linecap="round" />
                <path d="M 67,60 L 55,45 L 22,12" stroke="var(--gold-accent)" stroke-width="1.3" stroke-linecap="round" />
                <circle cx="50" cy="45" r="2" fill="var(--gold-accent)" />
                <!-- Comb crossed -->
                <path d="M 12,38 L 88,68" stroke="var(--gold-accent)" stroke-width="1.3" stroke-linecap="round" />
                <path d="M 17,40 L 19,45 M 22,42 L 24,47 M 27,44 L 29,49 M 32,46 L 34,51 M 37,48 L 39,53 M 42,50 L 44,55 M 47,52 L 49,57 M 52,54 L 54,59 M 57,56 L 59,61 M 62,58 L 64,63 M 67,60 L 69,65 M 72,62 L 74,67 M 77,64 L 79,69 M 82,66 L 84,71" stroke="var(--gold-accent)" stroke-width="0.8" />
            </svg>
        </div>

        <!-- Theme Toggle Button -->
        <button class="theme-toggle-btn" id="themeToggle" aria-label="Toggle Theme">
            <i class="fa-solid fa-moon"></i>
        </button>

        <!-- Elegant Shield Frame for Logo -->
        <div class="logo-shield-container">
            <svg class="logo-shield-svg" viewBox="0 0 100 115">
                <!-- Outer thick shield border with gold gradient -->
                <path d="M 50,2 C 78,2 98,22 98,60 C 98,90 75,108 50,114 C 25,108 2,90 2,60 C 2,22 22,2 50,2 Z" stroke-width="2.5" />
                <!-- Inner thin dashed shield border -->
                <path d="M 50,6 C 74,6 94,24 94,60 C 94,87 72,104 50,110 C 28,104 6,87 6,60 C 6,24 26,6 50,6 Z" fill="none" stroke-width="0.8" stroke-dasharray="2,2" />
            </svg>
            
            @if($restaurant->logo_path)
                <div class="logo-image-wrapper">
                    <img src="{{ asset('storage/'.$restaurant->logo_path) }}" alt="{{ $restaurant->name }}">
                </div>
            @else
                <div class="logo-image-wrapper">
                    <span class="logo-text-fallback">{{ substr($restaurant->name, 0, 2) }}</span>
                </div>
            @endif
        </div>

        <h1 class="brand-name">{{ $arabicName }}</h1>
        @if($englishName)
            <span class="brand-subname">{{ $englishName }}</span>
        @endif
        <span class="brand-tagline">Price List</span>

        @if($arabicDesc)
            <p class="brand-desc">{{ $arabicDesc }}</p>
        @endif
        @if($englishDesc)
            <p class="brand-desc-en">{{ $englishDesc }}</p>
        @endif
    </header>

    <!-- SEARCH BAR -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="ابحث في قائمة الخدمات...">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>

    <!-- EMPTY STATE FOR SEARCH -->
    <div class="empty-search-state" id="emptySearch">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>عذرًا، لم نعثر على نتائج مطابقة لبحثك.</p>
    </div>

    <!-- CATEGORIES & PRODUCTS GRID -->
    <div class="categories-grid" id="menuCategories">
        @foreach($categories as $category)
            @if($category->products->count())
                <section class="category-card" id="cat-{{ $category->id }}" data-category-name="{{ $category->name_ar }}">
                    <div class="category-header">
                        <h2 class="category-title">{{ $category->name_ar }}</h2>
                    </div>

                    <!-- Products List inside Category -->
                    <div class="products-list">
                        @foreach($category->products as $item)
                            @php
                                $nameParts = explode('/', $item->name);
                                $arabicName = trim($nameParts[0]);
                                $englishName = isset($nameParts[1]) ? trim($nameParts[1]) : '';
                            @endphp
                            
                            <div class="product-item" 
                                 id="osirix-product-{{ $item->id }}"
                                 data-product-name="{{ $item->name }}" 
                                 data-product-desc="{{ $item->description }}" 
                                 data-product-price="{{ number_format($item->displayPrice(), 0) }} EGP" 
                                 data-product-image="{{ $item->image_path ? asset('storage/'.$item->image_path) : '' }}"
                                 onclick="openProductModal(this)">
                                
                                <div class="product-row-flex">
                                    @if($item->image_path)
                                        <img class="product-thumbnail" src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $arabicName }}">
                                    @endif

                                    <div class="product-info-col">
                                        <div class="product-header">
                                            <div class="product-name-wrap">
                                                <span class="product-title-ar">{{ $arabicName }}</span>
                                                @if($englishName)
                                                    <span class="product-title-en">{{ $englishName }}</span>
                                                @endif
                                            </div>
                                            <div class="product-leader"></div>
                                            <span class="product-price-box">
                                                @include('menu.partials.product-price', ['product' => $item, 'decimals' => 0])
                                            </span>
                                        </div>

                                        @if($item->description)
                                            <p class="product-desc">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
    </div>

    <!-- BRANCHES & CONTACT INFO -->
    <section class="branches-contact-section">
        <div class="branches-header">
            <h3 class="branches-title">فروعنا ووسائل الاتصال</h3>
            <div class="branches-subtitle">يسعدنا تشريفكم لنا في أي من فروعنا أو تواصلكم المباشر معنا</div>
        </div>
        
        <div class="branches-grid">
            <a href="https://maps.app.goo.gl/ZewFF9ovQQRh9Hix6?g_st=ic" target="_blank" class="branch-card">
                <div class="branch-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h4 class="branch-name">الفرع الأول</h4>
                <p class="branch-address">الجيزة - ساقية مكي - شارع محمود حسين</p>
            </a>
            
            <a href="https://maps.app.goo.gl/eFB7jpGQSBzLo8As5?g_st=ic" target="_blank" class="branch-card">
                <div class="branch-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h4 class="branch-name">الفرع الثاني</h4>
                <p class="branch-address">الجيزة - شارع البحر الأعظم - أمام القرية الفرعونية</p>
            </a>
            
            <a href="https://maps.app.goo.gl/rXNxwoc1vuWAvEiQ8?g_st=ic" target="_blank" class="branch-card">
                <div class="branch-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h4 class="branch-name">الفرع الثالث</h4>
                <p class="branch-address">مصر الجديدة - شارع عمر بن الخطاب - هليوبوليس - بداخل مول تيفولي دوم</p>
            </a>
        </div>
        
        <div class="contact-action-wrapper">
            <a href="tel:01114620426" class="contact-action-btn btn-call">
                <i class="fa-solid fa-phone"></i>
                <div class="btn-text-content">
                    <span class="btn-lbl">اتصال هاتفي</span>
                    <span class="btn-val">01114620426</span>
                </div>
            </a>
            
            <a href="https://wa.me/201142073745" target="_blank" class="contact-action-btn btn-whatsapp">
                <i class="fa-brands fa-whatsapp"></i>
                <div class="btn-text-content">
                    <span class="btn-lbl">تواصل عبر واتساب</span>
                    <span class="btn-val">01142073745</span>
                </div>
            </a>
        </div>

        <div class="social-media-wrapper">
            <a href="https://www.tiktok.com/@alnerwegy_official?_r=1&_t=ZS-96k3Jalw7jo" target="_blank" class="social-icon-link tiktok-link" title="تيك توك">
                <i class="fa-brands fa-tiktok"></i>
            </a>
            <a href="https://www.instagram.com/el_nerwegy_official?igsh=b3dha2hyMHZuc2kw" target="_blank" class="social-icon-link instagram-link" title="إنستغرام">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="https://www.facebook.com/share/1CJtGgwbow/" target="_blank" class="social-icon-link facebook-link" title="فيسبوك">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://www.snapchat.com/add/mahmoudelnrwegy?share_id=pxmhaYKPWOw&locale=ar-EG" target="_blank" class="social-icon-link snapchat-link" title="سناب شات">
                <i class="fa-brands fa-snapchat"></i>
            </a>
            <a href="https://youtube.com/@alnerwegy_official?si=E6xTqKUNx4gXyHJk" target="_blank" class="social-icon-link youtube-link" title="يوتيوب">
                <i class="fa-brands fa-youtube"></i>
            </a>
        </div>
    </section>

    <!-- Vintage Divider line at bottom -->
    <div class="frame-ornament-center">
        <svg viewBox="0 0 100 20">
            <path d="M 10,10 L 45,10 C 47,8 49,8 50,10 C 51,8 53,8 55,10 L 90,10" stroke="var(--gold-accent)" stroke-width="1.5" fill="none"/>
            <polygon points="50,6 54,10 50,14 46,10" fill="var(--gold-accent)"/>
        </svg>
    </div>

    <!-- Power Badge -->
    <div class="menu-credit-wrapper">
        @include('menu.partials.powered-by')
    </div>
</div>

<!-- FLOATING FOOTER NAVIGATION -->
@if($categories->isNotEmpty())
    <nav class="footer-nav-bar" aria-label="التصنيفات">
        @foreach($categories as $category)
            @if($category->products->count())
                <a href="#cat-{{ $category->id }}" class="footer-nav-item">
                    {{ $category->name_ar }}
                </a>
            @endif
        @endforeach
    </nav>
@endif

@include('menu.partials.ai-assistant')

<!-- FLOATING SOCIAL CONTAINER -->
<div class="floating-social-container">
    <!-- Popover Menu Card -->
    <div class="social-popover-menu" id="socialPopover">
        <div class="popover-header">تابعنا وتواصل معنا</div>
        <div class="popover-grid">
            <a href="https://www.tiktok.com/@alnerwegy_official?_r=1&_t=ZS-96k3Jalw7jo" target="_blank" class="popover-link tiktok-link" title="تيك توك">
                <i class="fa-brands fa-tiktok"></i>
            </a>
            <a href="https://www.instagram.com/el_nerwegy_official?igsh=b3dha2hyMHZuc2kw" target="_blank" class="popover-link instagram-link" title="إنستغرام">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="https://www.facebook.com/share/1CJtGgwbow/" target="_blank" class="popover-link facebook-link" title="فيسبوك">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://www.snapchat.com/add/mahmoudelnrwegy?share_id=pxmhaYKPWOw&locale=ar-EG" target="_blank" class="popover-link snapchat-link" title="سناب شات">
                <i class="fa-brands fa-snapchat"></i>
            </a>
            <a href="https://youtube.com/@alnerwegy_official?si=E6xTqKUNx4gXyHJk" target="_blank" class="popover-link youtube-link" title="يوتيوب">
                <i class="fa-brands fa-youtube"></i>
            </a>
        </div>
        <div class="popover-actions">
            <a href="tel:01114620426" class="popover-action-btn btn-call">
                <span>اتصال هاتفي</span>
                <i class="fa-solid fa-phone"></i>
            </a>
            <a href="https://wa.me/201142073745" target="_blank" class="popover-action-btn btn-whatsapp">
                <span>تواصل عبر واتساب</span>
                <i class="fa-brands fa-whatsapp"></i>
            </a>
        </div>
    </div>
    
    <!-- Floating Action Button (FAB) -->
    <button class="fab-button" id="fabBtn" aria-label="وسائل التواصل">
        <i class="fa-solid fa-comments fab-icon-default"></i>
        <i class="fa-solid fa-xmark fab-icon-active"></i>
    </button>
</div>

<!-- PRODUCT DETAILS MODAL -->
<div class="modal-overlay" id="productModal" onclick="closeProductModal()">
    <div class="modal-card" onclick="event.stopPropagation()">
        <button class="modal-close-btn" onclick="closeProductModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <img class="modal-image" id="modalImage" src="" alt="صورة المنتج" style="display: none;">
        
        <div class="modal-body">
            <h3 class="modal-title-ar" id="modalTitleAr"></h3>
            <p class="modal-title-en" id="modalTitleEn"></p>
            <span class="modal-price" id="modalPrice"></span>
            <p class="modal-desc" id="modalDesc"></p>
        </div>
    </div>
</div>

<script>
    // Theme Toggle Functionality (Dark Paper / Light Paper)
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    const themeIcon = themeToggle.querySelector('i');

    // Load saved theme preference
    if (localStorage.getItem('paper-theme') === 'light') {
        body.classList.add('light-theme');
        themeIcon.className = 'fa-solid fa-sun';
    } else {
        body.classList.remove('light-theme');
        themeIcon.className = 'fa-solid fa-moon';
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('light-theme');
        if (body.classList.contains('light-theme')) {
            themeIcon.className = 'fa-solid fa-sun';
            localStorage.setItem('paper-theme', 'light');
        } else {
            themeIcon.className = 'fa-solid fa-moon';
            localStorage.setItem('paper-theme', 'dark');
        }
    });

    // Search Filtering Functionality
    const searchInput = document.getElementById('searchInput');
    const productItems = document.querySelectorAll('.product-item');
    const categoryCards = document.querySelectorAll('.category-card');
    const emptySearch = document.getElementById('emptySearch');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        let anyMatch = false;

        categoryCards.forEach(card => {
            let cardHasMatch = false;
            const items = card.querySelectorAll('.product-item');
            
            items.forEach(item => {
                const name = item.getAttribute('data-product-name').toLowerCase();
                const desc = (item.getAttribute('data-product-desc') || '').toLowerCase();
                
                if (name.includes(query) || desc.includes(query)) {
                    item.style.display = 'block';
                    cardHasMatch = true;
                    anyMatch = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (cardHasMatch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        if (anyMatch || query === '') {
            emptySearch.style.display = 'none';
        } else {
            emptySearch.style.display = 'block';
        }
    });

    // Scroll Category Active Highlight
    const navItems = document.querySelectorAll('.footer-nav-item');
    
    window.addEventListener('scroll', () => {
        let current = '';
        
        categoryCards.forEach(card => {
            const cardTop = card.offsetTop;
            const cardHeight = card.clientHeight;
            if (pageYOffset >= (cardTop - 140)) {
                current = card.getAttribute('id');
            }
        });

        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${current}`) {
                item.classList.add('active');
                
                // Scroll categories bar to keep active item centered
                item.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        });
    });

    // Modal popup functionality
    const productModal = document.getElementById('productModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitleAr = document.getElementById('modalTitleAr');
    const modalTitleEn = document.getElementById('modalTitleEn');
    const modalPrice = document.getElementById('modalPrice');
    const modalDesc = document.getElementById('modalDesc');

    function openProductModal(element) {
        const name = element.getAttribute('data-product-name');
        const desc = element.getAttribute('data-product-desc');
        const price = element.getAttribute('data-product-price');
        const image = element.getAttribute('data-product-image');

        const nameParts = name.split('/');
        const arName = nameParts[0].trim();
        const enName = nameParts[1] ? nameParts[1].trim() : '';

        modalTitleAr.textContent = arName;
        modalTitleEn.textContent = enName;
        modalPrice.textContent = price;
        modalDesc.textContent = desc || '';

        if (image) {
            modalImage.src = image;
            modalImage.style.display = 'block';
        } else {
            modalImage.src = '';
            modalImage.style.display = 'none';
        }

        productModal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeProductModal() {
        productModal.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Close modal on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeProductModal();
        }
    });

    // Floating Social Button Toggle
    const fabBtn = document.getElementById('fabBtn');
    const socialPopover = document.getElementById('socialPopover');

    if (fabBtn && socialPopover) {
        fabBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            fabBtn.classList.toggle('active');
            socialPopover.classList.toggle('open');
        });

        // Close popover when clicking anywhere else
        document.addEventListener('click', (e) => {
            if (!socialPopover.contains(e.target) && e.target !== fabBtn) {
                fabBtn.classList.remove('active');
                socialPopover.classList.remove('open');
            }
        });
    }
</script>
</body>
</html>
