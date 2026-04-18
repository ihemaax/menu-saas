<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-['Cairo'] bg-[#eaf5ff] text-slate-900">
@php($formatEgp = fn (float $price) => rtrim(rtrim(number_format($price, 2, '.', ''), '0'), '.').' ج.م')
<main class="mx-auto min-h-screen w-full max-w-md p-3 sm:p-4">
    <section class="overflow-hidden rounded-[2rem] border border-[#d6e9ff] bg-white shadow-[0_22px_60px_rgba(14,45,88,0.16)]">
        <header class="bg-gradient-to-br from-[#0f172a] via-[#1d4ed8] to-[#2563eb] px-4 pb-4 pt-5 text-white">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/40 bg-white/20 p-0.5 backdrop-blur">
                        <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/200x200?text=Logo' }}" class="h-full w-full rounded-xl object-cover" alt="{{ $restaurant->name }} logo">
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-blue-100">Quick Menu</p>
                        <h1 class="text-xl font-black leading-tight">{{ $restaurant->name }}</h1>
                    </div>
                </div>
                <div class="rounded-xl bg-white/15 px-2.5 py-1.5 text-[11px] font-semibold">30 min avg</div>
            </div>
            <p class="mt-3 line-clamp-2 text-xs text-blue-100">{{ $restaurant->description ?: 'واجهة تصفح سريعة شبيهة بتطبيقات طلب الطعام.' }}</p>
        </header>

        <div class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 px-4 pb-3 pt-3 backdrop-blur">
            <label class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                <input type="search" placeholder="Search menu" class="w-full border-0 bg-transparent p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0">
            </label>
            <div class="-mx-1 mt-3 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max gap-2 px-1">
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->id }}" class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-900">{{ $category->name_ar }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        @if($featuredProducts->isNotEmpty())
            <section class="border-b border-slate-100 bg-[#f8fbff] px-4 py-4">
                <h2 class="mb-3 text-sm font-black text-slate-700">Trending Now</h2>
                <div class="-mx-1 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <div class="flex min-w-max gap-3 px-1">
                        @foreach($featuredProducts as $product)
                            <article class="w-44 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                                <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/360x280?text=Food' }}" class="h-24 w-full object-cover" alt="{{ $product->name }}">
                                <div class="p-3">
                                    <h3 class="line-clamp-1 text-sm font-extrabold">{{ $product->name }}</h3>
                                    <p class="mt-1 text-[11px] text-slate-500">4.8 • 18 min</p>
                                    <p class="mt-1.5 text-base font-black text-blue-700">{{ $formatEgp((float) $product->price) }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="space-y-4 bg-[#eef6ff] px-4 pb-6 pt-4">
            @forelse($categories as $category)
                @if($category->products->isNotEmpty())
                    <section id="cat-{{ $category->id }}">
                        <div class="mb-2 flex items-center justify-between">
                            <h2 class="text-sm font-black text-slate-800">{{ $category->name_ar }}</h2>
                            <a href="#cat-{{ $category->id }}" class="text-[11px] font-semibold text-blue-700">See all</a>
                        </div>
                        <div class="space-y-2">
                            @foreach($category->products as $product)
                                <article class="grid grid-cols-[68px_1fr_auto] items-center gap-3 rounded-2xl border border-slate-200 bg-white p-2.5">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/160x160?text=Dish' }}" class="h-[68px] w-[68px] rounded-xl object-cover" alt="{{ $product->name }}">
                                    <div>
                                        <h3 class="line-clamp-1 text-sm font-extrabold text-slate-900">{{ $product->name }}</h3>
                                        <p class="mt-0.5 line-clamp-1 text-[11px] text-slate-500">{{ $product->description ?: 'Fresh taste, ready fast.' }}</p>
                                        <p class="mt-1 text-[10px] font-semibold text-slate-400">⭐ 4.7 • 15-20 min</p>
                                    </div>
                                    <p class="text-sm font-black text-blue-700">{{ $formatEgp((float) $product->price) }}</p>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center text-sm text-slate-500">لا يوجد أصناف متاحة حاليًا.</div>
            @endforelse
        </section>
    </section>
</main>
</body>
</html>
