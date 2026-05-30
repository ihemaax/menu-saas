<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Osirix | منيو ديجيتال' }}</title>
    @php($seoNoIndex = true)
    @include('partials.seo', ['seoTitle' => $title ?? 'Osirix'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Cairo'] antialiased bg-[#faf7f0] text-[#1c1710]">
    <main class="relative min-h-screen overflow-hidden">
        {{-- Background --}}
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_15%_20%,rgba(201,168,76,0.1),transparent_40%),radial-gradient(ellipse_at_85%_80%,rgba(45,122,111,0.08),transparent_40%)]"></div>
        <div class="osx-geo-pattern pointer-events-none absolute inset-0 opacity-60"></div>

        <div class="relative z-10 mx-auto grid min-h-screen w-full max-w-7xl items-center gap-8 px-4 py-6 sm:px-6 lg:grid-cols-[1fr_480px] lg:px-8">

            {{-- ═══════════════════════ LEFT PANEL (Desktop) ═══════════════════════ --}}
            <section class="hidden min-h-[700px] flex-col justify-between overflow-hidden rounded-3xl border border-[#c9a84c]/20 bg-gradient-to-br from-[#1c1710] via-[#2a2014] to-[#1c1710] p-8 text-white shadow-[0_30px_80px_rgba(28,23,16,0.25)] lg:flex">
                {{-- Decorative glows --}}
                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-[#c9a84c]/8 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-[#2d7a6f]/10 blur-3xl"></div>

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="relative inline-flex w-fit items-center gap-3">
                    <img src="{{ asset('osirix-logo.svg') }}" alt="Osirix" class="h-11 w-11 rounded-xl border border-[#c9a84c]/25 bg-[#f0e6ce] p-0.5 shadow-[0_0_20px_rgba(201,168,76,0.15)]">
                    <span>
                        <span class="block text-lg font-black uppercase tracking-[0.22em]">Osirix</span>
                        <span class="block text-[9px] font-bold tracking-[0.1em] text-[#c9a84c]/70">DIGITAL MENU PLATFORM</span>
                    </span>
                </a>

                {{-- Content --}}
                <div class="relative space-y-6">
                    <p class="inline-flex w-fit items-center gap-2 rounded-full border border-[#c9a84c]/20 bg-[#c9a84c]/10 px-4 py-2 text-xs font-black text-[#dfc06e]">
                        <i class="fa-solid fa-bolt"></i>
                        ادخل وعدّل المنيو بتاع مكانك في دقايق
                    </p>
                    <h1 class="max-w-xl text-[2.2rem] font-black leading-[1.35]">
                        لوحة بسيطة تمسك منها الأسعار والصور والـ QR
                        <span class="text-[#c9a84c]">من غير وجع دماغ.</span>
                    </h1>
                    <p class="max-w-lg text-[15px] font-semibold leading-8 text-white/45">
                        رتب الأصناف، غيّر الأسعار، وانشر لينك المنيو لعملائك. كل ده من مكان واحد واضح.
                    </p>
                </div>

                {{-- Stats + QR card --}}
                <div class="relative grid gap-3">
                    <div class="rounded-2xl border border-white/8 bg-white/[0.05] p-4 backdrop-blur-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <span class="text-sm font-black">نظرة سريعة</span>
                            <span class="rounded-full bg-[#2d7a6f] px-3 py-1 text-[10px] font-black">شغال</span>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach([
                                ['label' => 'فتحوا المنيو', 'val' => '1.8k'],
                                ['label' => 'الأقسام', 'val' => '12'],
                                ['label' => 'الأصناف', 'val' => '86'],
                            ] as $stat)
                                <div class="rounded-xl bg-white/[0.06] p-3">
                                    <span class="block text-[10px] font-bold text-white/40">{{ $stat['label'] }}</span>
                                    <strong class="mt-1 block text-xl font-black">{{ $stat['val'] }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-white/8 bg-white/[0.05] p-4 backdrop-blur-sm">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#c9a84c] to-[#dfc06e] text-[#1c1710]">
                            <i class="fa-solid fa-qrcode"></i>
                        </span>
                        <div>
                            <p class="text-sm font-black">QR جاهز للطباعة</p>
                            <p class="text-[11px] font-semibold text-white/40">حطه على الترابيزة أو ابعته واتساب.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ═══════════════════════ RIGHT PANEL (Form) ═══════════════════════ --}}
            <section class="mx-auto w-full max-w-[480px]">
                {{-- Mobile header --}}
                <div class="mb-5 flex items-center justify-between lg:hidden">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                        <img src="{{ asset('osirix-logo.svg') }}" alt="Osirix" class="h-10 w-10 rounded-xl border border-[#c9a84c]/20 p-0.5">
                        <span class="text-base font-black uppercase tracking-[0.18em] text-[#1c1710]">Osirix</span>
                    </a>
                    <a href="{{ route('home') }}" class="text-sm font-bold text-[#8b6914] transition hover:text-[#6d5210]">الرئيسية</a>
                </div>

                {{-- Form card --}}
                <div class="rounded-3xl border border-[#e8e0ce] bg-white/95 p-5 shadow-[0_20px_60px_rgba(28,23,16,0.08)] backdrop-blur-sm sm:p-8">
                    {{-- Desktop header inside card --}}
                    <div class="mb-6 hidden items-center justify-between lg:flex">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                            <img src="{{ asset('osirix-logo.svg') }}" alt="Osirix" class="h-10 w-10 rounded-xl border border-[#c9a84c]/20 p-0.5">
                            <span>
                                <span class="block text-base font-black uppercase tracking-[0.18em] text-[#1c1710]">Osirix</span>
                                <span class="block text-[10px] font-bold text-[#8b6914]">منيو إلكتروني احترافي</span>
                            </span>
                        </a>
                        <a href="{{ route('home') }}" class="rounded-lg border border-[#e8e0ce] px-4 py-2 text-xs font-bold text-[#8b6914] transition hover:border-[#c9a84c]/40 hover:bg-[#c9a84c]/5">الرئيسية</a>
                    </div>

                    {{ $slot }}
                </div>
            </section>
        </div>
    </main>
</body>
</html>
