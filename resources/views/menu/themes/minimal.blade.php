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
<<<<<<< HEAD
<body class="font-['Cairo'] bg-white text-slate-900">
@php($formatEgp = fn (float $price) => rtrim(rtrim(number_format($price, 2, '.', ''), '0'), '.').' ج.م')
<main class="mx-auto max-w-5xl px-4 pb-16 pt-6 sm:px-6 sm:pt-10">
    <header class="border-b border-slate-200 pb-8">
        <div class="grid gap-5 sm:grid-cols-[auto_1fr] sm:items-center">
            <div class="h-20 w-20 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-1">
                <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/240x240?text=Logo' }}" class="h-full w-full rounded-2xl object-cover" alt="{{ $restaurant->name }} logo">
            </div>
            <div>
                <h1 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ $restaurant->name }}</h1>
                <p class="mt-2 max-w-3xl text-sm leading-7 text-slate-500">{{ $restaurant->description ?: 'قائمة بسيطة بهوية هادئة تركّز على تفاصيل المنتج بوضوح.' }}</p>
=======
<body class="font-['Cairo'] bg-[#f4f7f5] text-slate-800">
@php($formatEgp = fn (float $price) => rtrim(rtrim(number_format($price, 2, '.', ''), '0'), '.').' ج.م')
<main class="mx-auto max-w-6xl px-3 pb-14 pt-4 sm:px-6 sm:pt-7">
    <section class="overflow-hidden rounded-[2.2rem] border border-[#dce7e1] bg-[#fbfdfc] shadow-[0_18px_60px_rgba(129,152,141,0.18)]">
        <header>
            <div class="relative h-52 sm:h-72">
                <img src="{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : 'https://placehold.co/1440x720?text=Clean+Brand+Cover' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#1a2b24]/35 via-transparent to-transparent"></div>
            </div>

            <div class="relative px-4 pb-6 sm:px-8">
                <div class="-mt-14 rounded-3xl border border-[#d8e5de] bg-[#f9fcfa] p-4 shadow-lg sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div class="flex items-end gap-4">
                            <div class="h-24 w-24 overflow-hidden rounded-full border-4 border-white bg-white shadow-md sm:h-28 sm:w-28">
                                <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/220x220?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
                            </div>
                            <div class="pb-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#6d8b7f]">Restaurant Profile</p>
                                <h1 class="mt-1 text-3xl font-black text-[#1f3028] sm:text-4xl">{{ $restaurant->name }}</h1>
                                <p class="mt-2 max-w-2xl text-sm leading-7 text-[#5f756b]">{{ $restaurant->description ?: 'هوية هادئة بطابع نظيف ومذاق متوازن لتجربة تقديم راقية.' }}</p>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-[#cfdfd7] bg-white px-4 py-2 text-xs font-bold text-[#6b8a7d]">Calm Menu • Freshly Curated</div>
                    </div>
                </div>
>>>>>>> codex-pr-12
            </div>
        </header>

<<<<<<< HEAD
        <div class="mt-6 grid gap-4 sm:grid-cols-[1fr_auto] sm:items-center">
            <label class="flex items-center gap-2 rounded-none border-b border-slate-300 py-2 text-sm text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                <input type="search" placeholder="ابحث داخل القائمة" class="w-full border-0 bg-transparent p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0">
            </label>
            <p class="text-xs font-semibold text-slate-400">Updated Daily</p>
        </div>
    </header>

    <section class="mt-5 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <div class="flex min-w-max gap-6 text-sm font-semibold text-slate-500">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="border-b border-transparent pb-2 transition hover:border-slate-900 hover:text-slate-900">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </section>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-10">
            <div class="mb-5 flex items-end justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Featured</h2>
                <span class="text-xs text-slate-400">Simple picks</span>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($featuredProducts as $product)
                    <article class="space-y-3">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/520x360?text=Dish' }}" class="h-44 w-full rounded-2xl object-cover" alt="{{ $product->name }}">
                        <h3 class="text-base font-semibold text-slate-900">{{ $product->name }}</h3>
                        <p class="line-clamp-2 text-sm text-slate-500">{{ $product->description ?: 'صنف خفيف بتقديم بسيط ومكونات متوازنة.' }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-400">4.8 • 20 min</span>
                            <span class="text-base font-semibold">{{ $formatEgp((float) $product->price) }}</span>
=======
        <section class="px-4 pb-4 sm:px-8">
            <div class="-mx-1 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max gap-3 px-1">
                    @php
                        $highlights = collect([
                            ['title' => 'ترشيحات اليوم', 'subtitle' => 'Taste Notes'],
                            ['title' => 'الأكثر طلبًا', 'subtitle' => 'Customer Picks'],
                            ['title' => 'وصول جديد', 'subtitle' => 'Fresh Additions'],
                        ]);
                    @endphp
                    @foreach($highlights as $highlight)
                        <article class="w-40 shrink-0 rounded-2xl border border-[#d7e4dd] bg-white p-3">
                            <p class="text-xs font-bold text-[#6b897d]">{{ $highlight['subtitle'] }}</p>
                            <p class="mt-1 text-sm font-extrabold text-[#1f3028]">{{ $highlight['title'] }}</p>
                        </article>
                    @endforeach

                    @foreach($categories->take(5) as $category)
                        @php($storyProduct = $category->products->first())
                        <a href="#cat-{{ $category->id }}" class="w-24 shrink-0 text-center">
                            <div class="mx-auto h-16 w-16 overflow-hidden rounded-full border-2 border-[#d2e0d8] bg-white p-0.5 shadow-sm">
                                <img src="{{ $storyProduct?->image_path ? asset('storage/'.$storyProduct->image_path) : 'https://placehold.co/160x160?text=+' }}" class="h-full w-full rounded-full object-cover" alt="{{ $category->name_ar }}">
                            </div>
                            <p class="mt-2 line-clamp-1 text-xs font-bold text-[#5e766b]">{{ $category->name_ar }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-[#d7e4dd] bg-white px-4 py-3">
                <label class="flex items-center gap-2 text-sm text-[#6a8378]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <input type="search" placeholder="ابحث في القائمة" class="w-full border-0 bg-transparent p-0 text-sm text-[#1f3028] placeholder:text-[#9bb1a7] focus:outline-none focus:ring-0">
                </label>
            </div>

            <div class="mt-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max items-center gap-2 rounded-2xl border border-[#d6e4dc] bg-[#f5faf7] p-2">
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->id }}" class="rounded-xl border border-transparent px-4 py-2 text-sm font-bold text-[#5e786d] transition hover:border-[#c7dad0] hover:bg-white">{{ $category->name_ar }}</a>
                    @endforeach
                </div>
            </div>
        </section>
    </section>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-8">
            <div class="mb-4 flex items-end justify-between">
                <h2 class="text-2xl font-black text-[#23362d]">Featured Selection</h2>
                <span class="text-xs font-semibold text-[#7c958a]">Curated for today</span>
            </div>
            <div class="grid gap-5 md:grid-cols-3">
                @foreach($featuredProducts as $product)
                    <article class="overflow-hidden rounded-3xl border border-[#d6e3dc] bg-white shadow-sm">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/560x420?text=Dish' }}" class="h-44 w-full object-cover" alt="{{ $product->name }}">
                        <div class="space-y-2 p-4">
                            <h3 class="text-base font-extrabold text-[#253830]">{{ $product->name }}</h3>
                            <p class="line-clamp-2 text-sm text-[#667d72]">{{ $product->description ?: 'صنف متوازن بتقديم ناعم ومكونات مختارة بعناية.' }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-[#8ba196]">4.8 • 18 دقيقة</span>
                                <span class="text-lg font-black text-[#5f7f72]">{{ $formatEgp((float) $product->price) }}</span>
                            </div>
>>>>>>> codex-pr-12
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

<<<<<<< HEAD
    <section class="mt-10 space-y-12">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}">
                    <h2 class="text-2xl font-semibold text-slate-900">{{ $category->name_ar }}</h2>
                    <div class="mt-4 divide-y divide-slate-200 border-y border-slate-200">
                        @foreach($category->products as $product)
                            <article class="grid gap-3 py-5 sm:grid-cols-[90px_1fr_auto] sm:items-center">
                                <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/200x200?text=Dish' }}" class="h-20 w-full rounded-xl object-cover sm:w-[90px]" alt="{{ $product->name }}">
                                <div>
                                    <h3 class="text-base font-semibold text-slate-900">{{ $product->name }}</h3>
                                    <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $product->description ?: 'وصف مختصر للصنف.' }}</p>
                                    <p class="mt-2 text-xs text-slate-400">جاهز خلال 20 دقيقة</p>
=======
    <section class="mt-8 space-y-6">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}" class="rounded-3xl border border-[#d5e2db] bg-[#fbfdfc] p-5 sm:p-6">
                    <div class="flex items-center justify-between gap-2">
                        <h2 class="text-2xl font-black text-[#22342c]">{{ $category->name_ar }}</h2>
                        <span class="text-xs font-semibold text-[#8aa094]">{{ $category->products->count() }} أصناف</span>
                    </div>

                    <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($category->products as $product)
                            <article class="overflow-hidden rounded-3xl border border-[#d9e6df] bg-white shadow-[0_8px_30px_rgba(142,166,154,0.12)]">
                                <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/640x460?text=Dish' }}" class="h-40 w-full object-cover" alt="{{ $product->name }}">
                                <div class="space-y-3 p-4">
                                    <div class="flex items-start justify-between gap-2">
                                        <h3 class="text-base font-extrabold text-[#22342c]">{{ $product->name }}</h3>
                                        <span class="rounded-full bg-[#edf5f1] px-2.5 py-1 text-xs font-bold text-[#648377]">{{ $formatEgp((float) $product->price) }}</span>
                                    </div>
                                    <p class="line-clamp-2 text-sm leading-6 text-[#6b8378]">{{ $product->description ?: 'وصف مختصر بطابع ناعم ومتوازن.' }}</p>
                                    <div class="flex items-center justify-between text-xs font-semibold text-[#89a095]">
                                        <span>تحضير خلال 20 دقيقة</span>
                                        <span>⭐ 4.8</span>
                                    </div>
>>>>>>> codex-pr-12
                                </div>
                                <p class="text-sm font-semibold text-slate-900">{{ $formatEgp((float) $product->price) }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
<<<<<<< HEAD
            <div class="rounded-2xl border border-slate-200 p-8 text-center text-slate-500">لا يوجد أصناف متاحة حاليًا.</div>
=======
            <div class="rounded-3xl border border-[#d8e5de] bg-white p-8 text-center text-[#70887d]">لا يوجد أصناف متاحة حاليًا.</div>
>>>>>>> codex-pr-12
        @endforelse
    </section>
</main>
</body>
</html>
