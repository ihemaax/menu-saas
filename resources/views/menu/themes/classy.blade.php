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
<body class="font-['Cairo'] bg-[#f4efe8] text-stone-900">
@php($formatEgp = fn (float $price) => rtrim(rtrim(number_format($price, 2, '.', ''), '0'), '.').' ج.م')
<main class="mx-auto max-w-6xl px-3 pb-12 pt-4 sm:px-6 sm:pt-7">
    <section class="overflow-hidden rounded-[2.25rem] border border-[#d7c6af] bg-[#fffaf3] shadow-[0_28px_80px_rgba(45,31,18,0.2)]">
        <header class="relative">
            <div class="relative h-52 sm:h-72">
                <img src="{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : 'https://placehold.co/1440x720?text=Luxury+Cover' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} banner">
                <div class="absolute inset-0 bg-gradient-to-t from-[#1f1912]/70 via-[#1f1912]/20 to-transparent"></div>
            </div>

            <div class="relative px-4 pb-6 sm:px-8">
                <div class="-mt-14 rounded-3xl border border-[#dcc6a8] bg-[#f8efe3] p-4 shadow-xl sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div class="flex items-end gap-4">
                            <div class="h-24 w-24 overflow-hidden rounded-full border-4 border-white bg-white shadow-lg sm:h-28 sm:w-28">
                                <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/220x220?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
                            </div>
                            <div class="pb-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#8a6b47]">Fine Dining Profile</p>
                                <h1 class="mt-1 text-3xl font-black text-[#24190f] sm:text-4xl">{{ $restaurant->name }}</h1>
                                <p class="mt-2 max-w-2xl text-sm text-[#5d4938]">{{ $restaurant->description ?: 'هوية راقية بطابع هادئ وتجربة تقديم فاخرة.' }}</p>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-[#d8bea0] bg-white/90 px-4 py-2 text-xs font-bold text-[#7a5f43]">Premium Experience • Daily Fresh</div>
                    </div>
                </div>
            </div>
        </header>

        <section class="px-4 pb-4 sm:px-8">
            <div class="-mx-1 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max gap-3 px-1">
                    @foreach($categories->take(6) as $category)
                        @php($storyProduct = $category->products->first())
                        <a href="#cat-{{ $category->id }}" class="w-24 shrink-0 text-center">
                            <div class="mx-auto h-16 w-16 overflow-hidden rounded-full border-2 border-[#dcc6a8] bg-white p-0.5 shadow-sm">
                                <img src="{{ $storyProduct?->image_path ? asset('storage/'.$storyProduct->image_path) : 'https://placehold.co/160x160?text=+' }}" class="h-full w-full rounded-full object-cover" alt="{{ $category->name_ar }}">
                            </div>
                            <p class="mt-2 line-clamp-1 text-xs font-bold text-[#6c533d]">{{ $category->name_ar }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-[#dec8ab] bg-white px-4 py-3">
                <label class="flex items-center gap-2 text-sm text-[#7a6147]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <input type="search" placeholder="ابحث عن وجبة أو مشروب" class="w-full border-0 bg-transparent p-0 text-sm text-[#2a1f15] placeholder:text-[#ab8c6a] focus:outline-none focus:ring-0">
                </label>
            </div>

            <div class="mt-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max items-center gap-2 rounded-2xl border border-[#dcc8af] bg-[#f8f3ec] p-2">
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->id }}" class="rounded-xl border border-transparent px-4 py-2 text-sm font-bold text-[#6e573e] transition hover:border-[#ccb08f] hover:bg-white">{{ $category->name_ar }}</a>
                    @endforeach
                </div>
            </div>
        </section>
    </section>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-7">
            <h2 class="text-2xl font-black text-[#2a1f15]">اختيارات مميزة</h2>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                @foreach($featuredProducts as $product)
                    <article class="grid overflow-hidden rounded-3xl border border-[#dbc7af] bg-[#fffdf9] shadow-sm sm:grid-cols-[220px_1fr]">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/640x480?text=Dish' }}" class="h-52 w-full object-cover sm:h-full" alt="{{ $product->name }}">
                        <div class="space-y-3 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#8b6f4f]">Chef Choice</p>
                            <h3 class="text-xl font-black text-[#261b11]">{{ $product->name }}</h3>
                            <p class="line-clamp-2 text-sm text-[#66503b]">{{ $product->description ?: 'طبق متوازن المذاق بمكونات مختارة بعناية.' }}</p>
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold text-[#8f7353]">4.9 • 25 دقيقة</p>
                                <p class="text-2xl font-black text-[#8a6234]">{{ $formatEgp((float) $product->price) }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-8 space-y-6">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}" class="rounded-3xl border border-[#dcc8af] bg-[#fffdf9] p-5 sm:p-6">
                    <h2 class="text-2xl font-black text-[#2a1f15]">{{ $category->name_ar }}</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        @foreach($category->products as $product)
                            <article class="rounded-2xl border border-[#e8d8c4] bg-white p-4">
                                <div class="flex gap-3">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/300x300?text=Dish' }}" class="h-24 w-24 rounded-2xl object-cover" alt="{{ $product->name }}">
                                    <div class="flex-1">
                                        <h3 class="text-base font-extrabold text-[#24190f]">{{ $product->name }}</h3>
                                        <p class="mt-1 line-clamp-2 text-xs text-[#6f5842]">{{ $product->description ?: 'وصف قصير للصنف.' }}</p>
                                        <div class="mt-2 flex items-center justify-between">
                                            <span class="text-[11px] font-semibold text-[#9e8261]">جاهز خلال 20 دقيقة</span>
                                            <span class="text-lg font-black text-[#8a6234]">{{ $formatEgp((float) $product->price) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="rounded-3xl border border-[#dcc8af] bg-[#fffdf9] p-8 text-center text-[#6c5540]">لا يوجد أصناف متاحة حالياً.</div>
        @endforelse
    </section>
</main>
</body>
</html>
