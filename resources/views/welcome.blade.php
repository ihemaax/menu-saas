<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $seoTitle = 'Osirix | منيو إلكتروني احترافي للمطاعم والكافيهات';
        $seoDescription = 'Osirix منصة منيو إلكتروني و QR Menu للمطاعم والكافيهات. اعرض المنيو بتاعك بشكل احترافي، عدّل الأسعار فورًا، وادّي عميلك تجربة موبايل سلسة.';
        $seoCanonical = route('home');
        $seoImage = asset('osirix-logo.svg');
        $annualWhatsAppUrl = 'https://wa.me/201206628718?text='.rawurlencode('أهلا، عايز أشترك في Osirix الباقة السنوية 2800 جنيه.');
        $semiAnnualWhatsAppUrl = 'https://wa.me/201206628718?text='.rawurlencode('أهلا، عايز أشترك في Osirix الباقة النصف سنوية 1500 جنيه.');

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'SoftwareApplication',
                    'name' => 'Osirix',
                    'applicationCategory' => 'BusinessApplication',
                    'operatingSystem' => 'Web',
                    'url' => route('home'),
                    'description' => $seoDescription,
                    'image' => $seoImage,
                    'offers' => [
                        [
                            '@type' => 'Offer',
                            'name' => 'اشتراك Osirix نصف سنوي',
                            'price' => '1500',
                            'priceCurrency' => 'EGP',
                            'availability' => 'https://schema.org/InStock',
                        ],
                        [
                            '@type' => 'Offer',
                            'name' => 'اشتراك Osirix سنوي',
                            'price' => '2800',
                            'priceCurrency' => 'EGP',
                            'availability' => 'https://schema.org/InStock',
                        ],
                    ],
                ],
            ],
        ];
    @endphp
    <title>{{ $seoTitle }}</title>
    @include('partials.seo')
    <script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .osx-hero-gradient {
            background: linear-gradient(165deg, #1a150e 0%, #2a2014 25%, #1c1710 50%, #14201c 75%, #1a150e 100%);
        }
        .osx-hero-glow-1 {
            position: absolute; top: -15%; right: -10%; width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 65%);
            filter: blur(40px); pointer-events: none;
        }
        .osx-hero-glow-2 {
            position: absolute; bottom: -10%; left: -5%; width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(45,122,111,0.12) 0%, transparent 60%);
            filter: blur(50px); pointer-events: none;
        }
        .osx-pricing-glow {
            background: radial-gradient(ellipse at center, rgba(201,168,76,0.06) 0%, transparent 70%);
        }
        .osx-grain {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
        }
        .osx-feature-gradient-1 { background: linear-gradient(145deg, #fdfbf5 0%, #f7f0de 100%); }
        .osx-feature-gradient-2 { background: linear-gradient(145deg, #f5fbf9 0%, #e8f5f2 100%); }
    </style>
</head>
<body class="osx-landing font-['Cairo'] bg-[#faf7f0] text-[#1c1710] antialiased">
    <main class="min-h-screen overflow-hidden">

        {{-- ═══════════════════════════════════════════════════
             HEADER
        ═══════════════════════════════════════════════════ --}}
        <header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-[#1c1710]/80 backdrop-blur-2xl">
            <div class="mx-auto flex h-[68px] max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="Osirix">
                    <img src="{{ asset('osirix-logo.svg') }}" alt="Osirix" class="h-9 w-9 rounded-lg border border-[#c9a84c]/30 bg-[#f0e6ce] p-0.5 shadow-[0_0_20px_rgba(201,168,76,0.15)]">
                    <span class="hidden sm:block">
                        <span class="block text-base font-black uppercase tracking-[0.22em] text-white">Osirix</span>
                        <span class="block text-[9px] font-bold text-[#c9a84c]/80 tracking-[0.1em]">DIGITAL MENU PLATFORM</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-7 text-[13px] font-bold text-white/55 lg:flex">
                    <a href="#features" class="transition hover:text-[#c9a84c]">المميزات</a>
                    <a href="#preview" class="transition hover:text-[#c9a84c]">التجربة</a>
                    <a href="#pricing" class="transition hover:text-[#c9a84c]">الأسعار</a>
                </nav>

                <div class="flex items-center gap-2">
                    <button id="osx-mobile-toggle" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-white/70 transition hover:bg-white/10 lg:hidden" aria-label="القائمة">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <a href="{{ route('login') }}" class="hidden rounded-lg px-4 py-2 text-[13px] font-bold text-white/60 transition hover:text-white sm:inline-flex">دخول</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-l from-[#c9a84c] to-[#dbb94f] px-5 py-2 text-[13px] font-black text-[#1c1710] shadow-[0_6px_20px_rgba(201,168,76,0.3)] transition hover:shadow-[0_8px_28px_rgba(201,168,76,0.4)]">
                        ابدأ الآن
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    </a>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="osx-mobile-menu" class="hidden border-t border-white/5 bg-[#1c1710]/95 px-4 pb-4 pt-2 backdrop-blur-2xl lg:hidden">
                <div class="flex flex-col gap-1">
                    <a href="#features" class="rounded-lg px-4 py-2.5 text-sm font-bold text-white/60 transition hover:bg-white/5 hover:text-[#c9a84c]">المميزات</a>
                    <a href="#preview" class="rounded-lg px-4 py-2.5 text-sm font-bold text-white/60 transition hover:bg-white/5 hover:text-[#c9a84c]">التجربة</a>
                    <a href="#pricing" class="rounded-lg px-4 py-2.5 text-sm font-bold text-white/60 transition hover:bg-white/5 hover:text-[#c9a84c]">الأسعار</a>
                    <a href="{{ route('login') }}" class="rounded-lg px-4 py-2.5 text-sm font-bold text-white/60 transition hover:bg-white/5">دخول</a>
                </div>
            </div>
        </header>


        {{-- ═══════════════════════════════════════════════════
             HERO — Dark, Rich, Impactful
        ═══════════════════════════════════════════════════ --}}
        <section class="osx-hero-gradient relative isolate overflow-hidden pt-[68px]">
            <div class="osx-hero-glow-1"></div>
            <div class="osx-hero-glow-2"></div>
            <div class="osx-grain pointer-events-none absolute inset-0"></div>
            {{-- Geometric pattern --}}
            <div class="osx-geo-pattern pointer-events-none absolute inset-0 opacity-70"></div>

            {{-- Egyptian decorative line top --}}
            <div class="pointer-events-none absolute inset-x-0 bottom-0 h-[1px] bg-gradient-to-l from-transparent via-[#c9a84c]/30 to-transparent"></div>

            <div class="relative mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 sm:py-24 lg:min-h-[calc(100vh-68px)] lg:grid-cols-[1.15fr_0.85fr] lg:gap-20 lg:px-8 lg:py-0">
                {{-- Text --}}
                <div class="osx-animate-in max-w-2xl lg:order-2">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#c9a84c]/25 bg-[#c9a84c]/10 px-4 py-2 text-xs font-black text-[#dfc06e] shadow-[0_0_20px_rgba(201,168,76,0.08)]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 12.5c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        منيو رقمي احترافي
                    </div>

                    <h1 class="mt-7 text-[2.5rem] font-black leading-[1.15] tracking-tight text-white sm:text-5xl lg:text-[3.5rem]">
                        منيو إلكتروني
                        <span class="osx-gold-shimmer block">يليق بمكانك.</span>
                    </h1>

                    <p class="mt-6 max-w-xl text-[15px] font-semibold leading-8 text-white/50 sm:text-lg">
                        Osirix يساعدك تعرض المنيو بتاع مطعمك أو كافيهك بشكل احترافي وسهل التحديث — من غير ما تطبع كل مرة.
                    </p>

                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('register') }}" id="hero-cta-primary" class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-gradient-to-l from-[#c9a84c] to-[#dfc06e] px-8 py-4 text-base font-black text-[#1c1710] shadow-[0_14px_40px_rgba(201,168,76,0.3)] transition hover:shadow-[0_18px_50px_rgba(201,168,76,0.4)]">
                            <i class="fa-solid fa-rocket text-sm"></i>
                            ابدأ الآن
                        </a>
                        <a href="#preview" id="hero-cta-secondary" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/[0.05] px-7 py-4 text-base font-bold text-white/80 backdrop-blur-sm transition hover:border-[#c9a84c]/30 hover:bg-white/10">
                            <i class="fa-solid fa-eye text-sm text-[#c9a84c]/70"></i>
                            شاهد مثال
                        </a>
                    </div>

                    {{-- Mini stats --}}
                    <div class="mt-10 flex items-center gap-6 border-t border-white/8 pt-7">
                        @foreach([
                            ['val' => 'QR', 'label' => 'جاهز للطباعة'],
                            ['val' => '24/7', 'label' => 'منيو شغال دايمًا'],
                            ['val' => 'RTL', 'label' => 'واجهة عربية'],
                        ] as $stat)
                            <div>
                                <strong class="block text-xl font-black text-[#c9a84c]">{{ $stat['val'] }}</strong>
                                <span class="text-[11px] font-bold text-white/35">{{ $stat['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Phone Mockup --}}
                <div class="osx-animate-in osx-animate-in-d2 flex justify-center lg:order-1 lg:justify-start">
                    <div class="osx-float relative">
                        {{-- Gold ring decorations --}}
                        <div class="pointer-events-none absolute -inset-4 rounded-[44px] border border-[#c9a84c]/15 shadow-[0_0_60px_rgba(201,168,76,0.05)]"></div>
                        <div class="pointer-events-none absolute -inset-9 rounded-[54px] border border-[#c9a84c]/8"></div>

                        {{-- Phone --}}
                        <div class="relative w-[270px] overflow-hidden rounded-[34px] border-[3px] border-[#c9a84c]/30 bg-white shadow-[0_30px_80px_rgba(0,0,0,0.35),0_0_0_1px_rgba(201,168,76,0.1)]">
                            {{-- Notch --}}
                            <div class="absolute left-1/2 top-2 z-10 h-[18px] w-[70px] -translate-x-1/2 rounded-full bg-[#1c1710]"></div>

                            <div class="pt-8">
                                {{-- Menu header --}}
                                <div class="flex items-center justify-between border-b border-[#e8e0ce] bg-[#faf7f0] px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-md bg-[#1c1710] text-[9px] font-black text-[#c9a84c]">
                                            <i class="fa-solid fa-crown"></i>
                                        </span>
                                        <div>
                                            <p class="text-[9px] font-bold text-[#8b6914]">Osirix</p>
                                            <p class="text-[12px] font-black text-[#1c1710]">Nile House</p>
                                        </div>
                                    </div>
                                    <span class="rounded-full bg-[#e8f5f2] px-2 py-0.5 text-[8px] font-black text-[#2d7a6f]">مفتوح</span>
                                </div>

                                {{-- Categories --}}
                                <div class="flex gap-1.5 bg-[#faf7f0] px-3 py-2">
                                    <span class="rounded-md bg-[#1c1710] px-2.5 py-1 text-[9px] font-black text-[#f0e6ce]">الأشهر</span>
                                    <span class="rounded-md bg-[#ece5d5] px-2.5 py-1 text-[9px] font-bold text-[#6b5f4d]">مشروبات</span>
                                    <span class="rounded-md bg-[#ece5d5] px-2.5 py-1 text-[9px] font-bold text-[#6b5f4d]">حلويات</span>
                                </div>

                                {{-- Items --}}
                                <div class="space-y-1.5 bg-[#faf7f0] px-3 pb-3">
                                    @foreach([
                                        ['name' => 'طبق Signature', 'desc' => 'لحم مشوي مع صوص خاص', 'price' => '185 ج', 'icon' => 'fa-bowl-food'],
                                        ['name' => 'لاتيه كراميل', 'desc' => 'إسبرسو مع حليب', 'price' => '95 ج', 'icon' => 'fa-mug-hot'],
                                        ['name' => 'كنافة نابلسية', 'desc' => 'قشطة وفستق', 'price' => '120 ج', 'icon' => 'fa-ice-cream'],
                                    ] as $item)
                                        <div class="flex items-center gap-2 rounded-lg border border-[#e8e0ce] bg-white p-2 shadow-[0_1px_4px_rgba(0,0,0,0.02)]">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-gradient-to-br from-[#c9a84c]/15 to-[#c9a84c]/5 text-[#8b6914]">
                                                <i class="fa-solid {{ $item['icon'] }} text-[10px]"></i>
                                            </span>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-[11px] font-black text-[#1c1710]">{{ $item['name'] }}</p>
                                                <p class="text-[8px] font-semibold text-[#6b5f4d]/60">{{ $item['desc'] }}</p>
                                            </div>
                                            <span class="shrink-0 rounded-md bg-[#2d7a6f]/10 px-1.5 py-0.5 text-[9px] font-black text-[#2d7a6f]">{{ $item['price'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Bottom --}}
                                <div class="flex items-center justify-center bg-[#f0ebe0] py-2 text-[8px] font-bold text-[#6b5f4d]/40">
                                    Powered by Osirix
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════════════════
             TRUST STRIP — Light warm section
        ═══════════════════════════════════════════════════ --}}
        <section class="relative bg-white py-10 sm:py-12">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    @foreach([
                        ['icon' => 'fa-qrcode', 'title' => 'منيو QR', 'text' => 'كود واحد ثابت يشتغل على أي موبايل', 'gradient' => 'from-[#c9a84c]/15 to-[#c9a84c]/5'],
                        ['icon' => 'fa-bolt', 'title' => 'تحديث فوري', 'text' => 'عدّل الأسعار والصور وقتها تظهر', 'gradient' => 'from-[#2d7a6f]/15 to-[#2d7a6f]/5'],
                        ['icon' => 'fa-store', 'title' => 'للمطاعم والكافيهات', 'text' => 'وكمان الصالونات وأي بزنس بمنتجات', 'gradient' => 'from-[#c9a84c]/15 to-[#c9a84c]/5'],
                    ] as $index => $item)
                        <div class="osx-animate-in osx-animate-in-d{{ $index + 1 }} flex items-center gap-4 rounded-2xl border border-[#e8e0ce] bg-gradient-to-br {{ $item['gradient'] }} px-5 py-5 shadow-[0_4px_16px_rgba(0,0,0,0.03)]">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-[#8b6914] shadow-[0_2px_8px_rgba(0,0,0,0.05)]">
                                <i class="fa-solid {{ $item['icon'] }} text-lg"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-black text-[#1c1710]">{{ $item['title'] }}</h3>
                                <p class="mt-0.5 text-xs font-semibold text-[#6b5f4d]/80">{{ $item['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════════════════
             PROBLEM / SOLUTION
        ═══════════════════════════════════════════════════ --}}
        <section class="relative bg-[#faf7f0] py-16 sm:py-20">
            <div class="osx-geo-pattern pointer-events-none absolute inset-0 opacity-50"></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-12 max-w-2xl text-center">
                    <p class="inline-flex items-center gap-2 text-sm font-black text-[#8b6914]">
                        <span class="inline-block h-px w-6 bg-[#c9a84c]/40"></span>
                        ليه Osirix؟
                        <span class="inline-block h-px w-6 bg-[#c9a84c]/40"></span>
                    </p>
                    <h2 class="mt-4 text-3xl font-black leading-[1.3] sm:text-[2.5rem]">
                        المنيو الورقي كان كفاية.<br>
                        <span class="text-[#8b6914]">دلوقتي الموضوع اتغير.</span>
                    </h2>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    {{-- Problem --}}
                    <div class="osx-animate-in overflow-hidden rounded-2xl border border-[#f0d0c8] bg-white shadow-[0_12px_36px_rgba(180,80,60,0.06)]">
                        <div class="border-b border-[#f0d0c8]/60 bg-gradient-to-l from-[#fdf3f0] to-white px-6 py-4 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#c0503c]/10 text-[#c0503c] shadow-[inset_0_2px_4px_rgba(192,80,60,0.1)]">
                                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                                </span>
                                <h3 class="text-lg font-black text-[#9a3a28]">المشكلة</h3>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <ul class="space-y-5">
                                @foreach([
                                    'كل تغيير سعر = تصميم جديد + طباعة + تكلفة',
                                    'المنيو الورقي بيتلف وبيقدم ومش عملي',
                                    'العميل مش بيلاقي اللي يدوّر عليه بسرعة',
                                ] as $pain)
                                    <li class="flex items-start gap-3 text-sm font-semibold leading-7 text-[#5a4f3d]">
                                        <span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#c0503c]/10 text-[8px] text-[#c0503c]">
                                            <i class="fa-solid fa-xmark"></i>
                                        </span>
                                        {{ $pain }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Solution --}}
                    <div class="osx-animate-in osx-animate-in-d2 overflow-hidden rounded-2xl border border-[#b8ddd6] bg-white shadow-[0_12px_36px_rgba(45,122,111,0.06)]">
                        <div class="border-b border-[#b8ddd6]/60 bg-gradient-to-l from-[#f0faf8] to-white px-6 py-4 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2d7a6f]/10 text-[#2d7a6f] shadow-[inset_0_2px_4px_rgba(45,122,111,0.1)]">
                                    <i class="fa-solid fa-check text-sm"></i>
                                </span>
                                <h3 class="text-lg font-black text-[#236a60]">الحل مع Osirix</h3>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <ul class="space-y-5">
                                @foreach([
                                    'عدّل الأسعار والصور في ثانية من لوحة التحكم',
                                    'QR واحد ثابت — العميل يفتح آخر نسخة دايمًا',
                                    'منيو مرتب بأقسام واضحة وتجربة موبايل سلسة',
                                ] as $fix)
                                    <li class="flex items-start gap-3 text-sm font-semibold leading-7 text-[#5a4f3d]">
                                        <span class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#2d7a6f]/10 text-[8px] text-[#2d7a6f]">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                        {{ $fix }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════════════════
             FEATURES — 4 Rich Cards
        ═══════════════════════════════════════════════════ --}}
        <section id="features" class="relative bg-white py-16 sm:py-20">
            {{-- Divider --}}
            <div class="pointer-events-none absolute inset-x-[10%] top-0 h-[1px] bg-gradient-to-l from-transparent via-[#c9a84c]/25 to-transparent"></div>

            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-14 max-w-2xl text-center">
                    <p class="inline-flex items-center gap-2 text-sm font-black text-[#8b6914]">
                        <span class="inline-block h-px w-6 bg-[#c9a84c]/40"></span>
                        المميزات
                        <span class="inline-block h-px w-6 bg-[#c9a84c]/40"></span>
                    </p>
                    <h2 class="mt-4 text-3xl font-black leading-[1.3] sm:text-[2.5rem]">
                        كل اللي محتاجه، في مكان واحد
                    </h2>
                    <p class="mt-4 text-base font-semibold text-[#6b5f4d]">
                        أدوات بسيطة تخلي المنيو بتاعك يشتغل صح من أول يوم.
                    </p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach([
                        [
                            'icon' => 'fa-qrcode',
                            'title' => 'QR Menu جاهز',
                            'text' => 'كود QR واحد يفضل ثابت. اطبعه أو ابعته. العميل يفتح المنيو في ثانية.',
                            'bg' => 'osx-feature-gradient-1', 'iconBg' => 'bg-[#1c1710]', 'iconColor' => 'text-[#c9a84c]',
                        ],
                        [
                            'icon' => 'fa-layer-group',
                            'title' => 'أقسام ومنتجات',
                            'text' => 'رتّب الأقسام، ضيف المنتجات بصور وأسعار ووصف. كله من لوحة تحكم سهلة.',
                            'bg' => 'osx-feature-gradient-2', 'iconBg' => 'bg-[#2d7a6f]', 'iconColor' => 'text-white',
                        ],
                        [
                            'icon' => 'fa-pen-to-square',
                            'title' => 'تحديث فوري',
                            'text' => 'غيّر سعر أو صورة، التعديل يظهر لحظيًا على المنيو. بدون طباعة جديدة.',
                            'bg' => 'osx-feature-gradient-2', 'iconBg' => 'bg-[#2d7a6f]', 'iconColor' => 'text-white',
                        ],
                        [
                            'icon' => 'fa-mobile-screen-button',
                            'title' => 'تصميم موبايل',
                            'text' => 'المنيو معمول Mobile-first. يتفتح سريع ويتقري بوضوح على أي شاشة.',
                            'bg' => 'osx-feature-gradient-1', 'iconBg' => 'bg-[#1c1710]', 'iconColor' => 'text-[#c9a84c]',
                        ],
                    ] as $index => $feature)
                        <article class="osx-card-hover osx-animate-in osx-animate-in-d{{ $index + 1 }} group rounded-2xl border border-[#e8e0ce] {{ $feature['bg'] }} p-6 shadow-[0_6px_24px_rgba(0,0,0,0.04)]">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl {{ $feature['iconBg'] }} {{ $feature['iconColor'] }} shadow-lg transition group-hover:scale-110">
                                <i class="fa-solid {{ $feature['icon'] }} text-lg"></i>
                            </span>
                            <h3 class="mt-5 text-lg font-black text-[#1c1710]">{{ $feature['title'] }}</h3>
                            <p class="mt-2 text-[13px] font-semibold leading-7 text-[#6b5f4d]">{{ $feature['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════════════════
             PREVIEW — Client Experience
        ═══════════════════════════════════════════════════ --}}
        <section id="preview" class="relative bg-[#faf7f0] py-16 sm:py-20">
            <div class="osx-geo-pattern pointer-events-none absolute inset-0 opacity-50"></div>
            <div class="pointer-events-none absolute inset-x-[10%] top-0 h-[1px] bg-gradient-to-l from-transparent via-[#c9a84c]/20 to-transparent"></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
                    {{-- Text --}}
                    <div class="osx-animate-in">
                        <p class="inline-flex items-center gap-2 text-sm font-black text-[#8b6914]">
                            <span class="inline-block h-px w-6 bg-[#c9a84c]/40"></span>
                            تجربة العميل
                        </p>
                        <h2 class="mt-4 text-3xl font-black leading-[1.3] sm:text-[2.5rem]">
                            شوف التجربة
                            <span class="text-[#8b6914]">من عين العميل</span>
                        </h2>
                        <p class="mt-4 max-w-lg text-base font-semibold leading-8 text-[#6b5f4d]">
                            العميل يفتح QR أو لينك، يشوف المنيو مرتب بأقسام، يختار اللي يعجبه. بسيط، سريع، ومريح.
                        </p>

                        <div class="mt-8 grid gap-3 sm:grid-cols-2">
                            @foreach([
                                ['icon' => 'fa-palette', 'text' => 'واجهة نظيفة ومناسبة للمطاعم'],
                                ['icon' => 'fa-images', 'text' => 'صور وأسعار واضحة'],
                                ['icon' => 'fa-expand', 'text' => 'يشتغل على كل الشاشات'],
                                ['icon' => 'fa-globe', 'text' => 'بدون تطبيق — من المتصفح'],
                            ] as $item)
                                <div class="flex items-center gap-3 rounded-xl border border-[#e8e0ce] bg-white px-4 py-3 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#2d7a6f]/10 text-[11px] text-[#2d7a6f]">
                                        <i class="fa-solid {{ $item['icon'] }}"></i>
                                    </span>
                                    <span class="text-[13px] font-bold text-[#3d3529]">{{ $item['text'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="osx-animate-in osx-animate-in-d2 flex justify-center">
                        <div class="relative">
                            <div class="pointer-events-none absolute -inset-8 rounded-[50px] bg-[radial-gradient(circle,rgba(201,168,76,0.08)_0%,transparent_70%)]"></div>

                            <div class="relative w-[290px] overflow-hidden rounded-[34px] border-[3px] border-[#c9a84c]/30 bg-white shadow-[0_25px_65px_rgba(0,0,0,0.12),0_0_0_1px_rgba(201,168,76,0.1)]">
                                <div class="absolute left-1/2 top-2 z-10 h-[18px] w-[70px] -translate-x-1/2 rounded-full bg-[#1c1710]"></div>

                                <div class="pt-8">
                                    <div class="border-b border-[#e8e0ce] bg-[#faf7f0] px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#1c1710] text-[10px] font-black text-[#c9a84c]">N</span>
                                            <div>
                                                <p class="text-[12px] font-black text-[#1c1710]">Nile House</p>
                                                <p class="text-[9px] font-semibold text-[#6b5f4d]/60">مطعم وكافيه</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-1.5 bg-[#faf7f0] px-3 py-2">
                                        <span class="rounded-md bg-[#1c1710] px-2.5 py-1 text-[9px] font-black text-[#f0e6ce]">الأشهر</span>
                                        <span class="rounded-md bg-[#ece5d5] px-2.5 py-1 text-[9px] font-bold text-[#6b5f4d]">مشروبات</span>
                                        <span class="rounded-md bg-[#ece5d5] px-2.5 py-1 text-[9px] font-bold text-[#6b5f4d]">حلويات</span>
                                    </div>

                                    <div class="space-y-1.5 bg-[#faf7f0] px-3 pb-3">
                                        @foreach([
                                            ['name' => 'مشاوي مشكل', 'price' => '220 ج'],
                                            ['name' => 'فتة باللحمة', 'price' => '165 ج'],
                                            ['name' => 'سلطة سيزر', 'price' => '85 ج'],
                                            ['name' => 'عصير مانجو', 'price' => '55 ج'],
                                        ] as $item)
                                            <div class="flex items-center justify-between rounded-lg border border-[#e8e0ce] bg-white px-3 py-2 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                                                <div class="flex items-center gap-2">
                                                    <div class="h-7 w-7 rounded-md bg-[#c9a84c]/10"></div>
                                                    <span class="text-[10px] font-bold text-[#1c1710]">{{ $item['name'] }}</span>
                                                </div>
                                                <span class="text-[9px] font-black text-[#2d7a6f]">{{ $item['price'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="bg-[#f0ebe0] py-2 text-center text-[8px] font-bold text-[#6b5f4d]/40">Powered by Osirix</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════════════════
             PRICING
        ═══════════════════════════════════════════════════ --}}
        <section id="pricing" class="relative bg-white py-16 sm:py-20">
            <div class="osx-pricing-glow pointer-events-none absolute inset-0"></div>
            <div class="pointer-events-none absolute inset-x-[10%] top-0 h-[1px] bg-gradient-to-l from-transparent via-[#c9a84c]/25 to-transparent"></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-12 max-w-2xl text-center">
                    <p class="inline-flex items-center gap-2 text-sm font-black text-[#8b6914]">
                        <span class="inline-block h-px w-6 bg-[#c9a84c]/40"></span>
                        الأسعار
                        <span class="inline-block h-px w-6 bg-[#c9a84c]/40"></span>
                    </p>
                    <h2 class="mt-4 text-3xl font-black leading-[1.3] sm:text-[2.5rem]">
                        باقة واحدة كاملة. الاختيار في المدة بس.
                    </h2>
                    <p class="mt-4 text-base font-semibold text-[#6b5f4d]">
                        نفس المميزات لكل عميل. اختار الأنسب ليك وابدأ.
                    </p>
                </div>

                <div class="mx-auto grid max-w-4xl gap-6 lg:grid-cols-2">
                    {{-- Annual --}}
                    <article class="osx-card-hover relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1c1710] via-[#2a2014] to-[#1c1710] p-8 text-[#f0e6ce] shadow-[0_20px_60px_rgba(28,23,16,0.25)]">
                        {{-- Decorative --}}
                        <div class="pointer-events-none absolute -left-8 -top-8 h-32 w-32 rounded-full bg-[#c9a84c]/8"></div>
                        <div class="pointer-events-none absolute -bottom-4 -right-4 h-20 w-20 rounded-full bg-[#2d7a6f]/10"></div>

                        <span class="relative inline-flex items-center gap-1.5 rounded-full bg-gradient-to-l from-[#c9a84c] to-[#dfc06e] px-4 py-1.5 text-xs font-black text-[#1c1710] shadow-[0_4px_12px_rgba(201,168,76,0.3)]">
                            <i class="fa-solid fa-star text-[9px]"></i>
                            الأوفر
                        </span>

                        <p class="mt-5 text-sm font-bold text-[#c9a84c]">اشتراك سنوي</p>
                        <div class="mt-3 flex items-end gap-2">
                            <strong class="text-5xl font-black sm:text-6xl">2800</strong>
                            <span class="mb-2 text-sm font-bold text-[#f0e6ce]/50">جنيه / سنة</span>
                        </div>
                        <p class="mt-3 text-sm font-semibold leading-7 text-[#f0e6ce]/50">يعني حوالي 233 جنيه في الشهر. واجهة محترمة شغالة طول السنة.</p>

                        <div class="mt-6 space-y-2.5">
                            @foreach(['لينك باسم مكانك', 'QR جاهز للطباعة', 'لوحة تحكم عربية', 'أقسام ومنتجات وصور', 'تصميم موبايل سريع', 'إحصائيات زيارات'] as $feat)
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#c9a84c]/15 text-[8px] text-[#c9a84c]">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-[13px] font-bold text-[#f0e6ce]/70">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ $annualWhatsAppUrl }}" target="_blank" rel="noopener" class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-l from-[#c9a84c] to-[#dfc06e] px-6 py-4 text-base font-black text-[#1c1710] shadow-[0_8px_24px_rgba(201,168,76,0.25)] transition hover:shadow-[0_12px_32px_rgba(201,168,76,0.35)]">
                            <i class="fa-solid fa-crown text-sm"></i>
                            اشترك سنوي
                        </a>
                    </article>

                    {{-- Semi-Annual --}}
                    <article class="osx-card-hover overflow-hidden rounded-3xl border border-[#e8e0ce] bg-gradient-to-br from-[#fdfbf5] to-[#f5eedd] p-8 shadow-[0_12px_36px_rgba(0,0,0,0.05)]">
                        <p class="text-sm font-black text-[#2d7a6f]">اشتراك نصف سنوي</p>
                        <div class="mt-3 flex items-end gap-2">
                            <strong class="text-5xl font-black text-[#1c1710] sm:text-6xl">1500</strong>
                            <span class="mb-2 text-sm font-bold text-[#6b5f4d]">جنيه / 6 شهور</span>
                        </div>
                        <p class="mt-3 text-sm font-semibold leading-7 text-[#6b5f4d]">نفس النظام ونفس المميزات، لمدة أقصر لو حابب تبدأ خطوة بخطوة.</p>

                        <div class="mt-6 space-y-2.5">
                            @foreach(['لينك باسم مكانك', 'QR جاهز للطباعة', 'لوحة تحكم عربية', 'أقسام ومنتجات وصور', 'تصميم موبايل سريع', 'إحصائيات زيارات'] as $feat)
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2d7a6f]/10 text-[8px] text-[#2d7a6f]">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-[13px] font-bold text-[#5a4f3d]">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ $semiAnnualWhatsAppUrl }}" target="_blank" rel="noopener" class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-[#1c1710] bg-white px-6 py-4 text-base font-black text-[#1c1710] shadow-[0_4px_14px_rgba(0,0,0,0.06)] transition hover:bg-[#1c1710] hover:text-[#f0e6ce]">
                            <i class="fa-solid fa-calendar-days text-sm"></i>
                            اشترك نصف سنوي
                        </a>
                    </article>
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════════════════
             CTA FINAL
        ═══════════════════════════════════════════════════ --}}
        <section class="relative bg-[#faf7f0] py-14 sm:py-16">
            <div class="osx-geo-pattern pointer-events-none absolute inset-0 opacity-40"></div>

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-3xl border border-[#c9a84c]/20 bg-white p-8 text-center shadow-[0_16px_48px_rgba(201,168,76,0.08)] sm:p-12">
                    {{-- Decorative corners --}}
                    <div class="pointer-events-none absolute -left-4 -top-4 h-16 w-16 rounded-full bg-[#c9a84c]/5"></div>
                    <div class="pointer-events-none absolute -bottom-4 -right-4 h-16 w-16 rounded-full bg-[#2d7a6f]/5"></div>

                    <div class="mx-auto mb-5 flex items-center justify-center gap-3 text-[#c9a84c]/50">
                        <div class="h-px w-10 bg-gradient-to-l from-[#c9a84c]/40 to-transparent"></div>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" opacity="0.6"><path d="M12 2L2 19h20L12 2zm0 4l7 11H5l7-11z"/></svg>
                        <div class="h-px w-10 bg-gradient-to-r from-[#c9a84c]/40 to-transparent"></div>
                    </div>

                    <h2 class="osx-animate-in text-3xl font-black leading-[1.35] sm:text-4xl">
                        جاهز تبدأ؟
                        <span class="osx-gold-shimmer">خلّي المنيو بتاعك يليق باسمك.</span>
                    </h2>
                    <p class="osx-animate-in osx-animate-in-d1 mx-auto mt-4 max-w-xl text-base font-semibold leading-8 text-[#6b5f4d]">
                        سجّل في دقيقة، رتّب المنيو، واطبع QR. العميل يفتحه من الموبايل بدون تطبيق.
                    </p>
                    <div class="osx-animate-in osx-animate-in-d2 mt-7 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <a href="{{ route('register') }}" id="cta-final-primary" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-l from-[#c9a84c] to-[#dfc06e] px-8 py-4 text-base font-black text-[#1c1710] shadow-[0_12px_32px_rgba(201,168,76,0.25)] transition hover:shadow-[0_16px_40px_rgba(201,168,76,0.35)]">
                            <i class="fa-solid fa-rocket text-sm"></i>
                            ابدأ الآن
                        </a>
                        <a href="{{ $annualWhatsAppUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-7 py-4 text-base font-bold text-[#1c1710] transition hover:border-[#c9a84c]/40 hover:bg-[#c9a84c]/8">
                            <i class="fa-brands fa-whatsapp text-[#25D366]"></i>
                            تواصل معانا
                        </a>
                    </div>
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════════════════
             FOOTER
        ═══════════════════════════════════════════════════ --}}
        <footer class="border-t border-[#e8e0ce] bg-white py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center gap-6 sm:flex-row sm:justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('osirix-logo.svg') }}" alt="Osirix" class="h-8 w-8 rounded-md border border-[#c9a84c]/20 p-0.5">
                        <div>
                            <span class="block text-sm font-black uppercase tracking-[0.15em] text-[#1c1710]">Osirix</span>
                            <span class="block text-[10px] font-semibold text-[#6b5f4d]/60">منيو إلكتروني احترافي</span>
                        </div>
                    </div>
                    <nav class="flex items-center gap-6 text-sm font-bold text-[#6b5f4d]">
                        <a href="{{ route('home') }}" class="transition hover:text-[#8b6914]">الرئيسية</a>
                        <a href="{{ route('login') }}" class="transition hover:text-[#8b6914]">دخول</a>
                        <a href="{{ route('register') }}" class="transition hover:text-[#8b6914]">إنشاء حساب</a>
                    </nav>
                </div>
                <div class="mt-6 border-t border-[#e8e0ce] pt-6 text-center text-xs font-semibold text-[#6b5f4d]/50">
                    © {{ date('Y') }} Osirix. جميع الحقوق محفوظة.
                </div>
            </div>
        </footer>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('osx-mobile-toggle');
            const menu = document.getElementById('osx-mobile-menu');
            if (toggle && menu) {
                toggle.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                    const icon = toggle.querySelector('i');
                    if (menu.classList.contains('hidden')) {
                        icon.classList.remove('fa-xmark');
                        icon.classList.add('fa-bars');
                    } else {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-xmark');
                    }
                });
                menu.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        menu.classList.add('hidden');
                        const icon = toggle.querySelector('i');
                        icon.classList.remove('fa-xmark');
                        icon.classList.add('fa-bars');
                    });
                });
            }
        });
    </script>
</body>
</html>
