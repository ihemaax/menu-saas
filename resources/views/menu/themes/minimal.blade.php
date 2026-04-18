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
            </div>
        </div>

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
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

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
                                </div>
                                <p class="text-sm font-semibold text-slate-900">{{ $formatEgp((float) $product->price) }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="rounded-2xl border border-slate-200 p-8 text-center text-slate-500">لا يوجد أصناف متاحة حاليًا.</div>
        @endforelse
    </section>
</main>
</body>
</html>
