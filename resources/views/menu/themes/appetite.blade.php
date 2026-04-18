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
<body class="font-['Cairo'] bg-[#0a0a0c] text-zinc-100">
@php($formatEgp = fn (float $price) => rtrim(rtrim(number_format($price, 2, '.', ''), '0'), '.').' ج.م')
<main class="mx-auto max-w-7xl px-3 pb-12 pt-4 sm:px-6">
    <header class="overflow-hidden rounded-[2rem] border-2 border-orange-500 bg-[#141416] shadow-[0_28px_70px_rgba(249,115,22,0.25)]">
        <div class="grid gap-4 p-4 sm:grid-cols-[1.35fr_1fr] sm:p-6">
            <div class="rounded-3xl bg-gradient-to-br from-red-600 via-orange-500 to-amber-400 p-5 text-zinc-950">
                <div class="flex items-center justify-between">
                    <span class="rounded-full border border-zinc-900/20 bg-zinc-950/10 px-3 py-1 text-xs font-black uppercase tracking-[0.2em]">Street Fuel</span>
                    <div class="h-14 w-14 overflow-hidden rounded-2xl border-2 border-zinc-950/30 bg-white/85">
                        <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/180x180?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
                    </div>
                </div>
                <h1 class="mt-4 text-3xl font-black leading-tight sm:text-4xl">{{ $restaurant->name }}</h1>
                <p class="mt-2 max-w-2xl text-sm font-semibold text-zinc-900/80">{{ $restaurant->description ?: 'نكهات جريئة، هيدر قوي، وتجربة مشاهدة ممتعة وسريعة.' }}</p>
                <div class="mt-4 flex flex-wrap gap-2 text-xs font-bold">
                    <span class="rounded-full bg-zinc-950 px-3 py-1 text-white">Hot Deals</span>
                    <span class="rounded-full bg-white px-3 py-1 text-zinc-950">Fast Pickup</span>
                    <span class="rounded-full bg-zinc-900/10 px-3 py-1">Fresh Daily</span>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-3xl border border-zinc-700">
                <img src="{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : 'https://placehold.co/820x620?text=Street+Food' }}" class="h-full min-h-[220px] w-full object-cover" alt="cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <label class="absolute inset-x-3 bottom-3 flex items-center gap-2 rounded-2xl border border-zinc-500 bg-black/65 px-3 py-2 text-sm text-zinc-200 backdrop-blur">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <input type="search" placeholder="ابحث عن برجر، فرايز..." class="w-full border-0 bg-transparent p-0 text-sm placeholder:text-zinc-400 focus:outline-none focus:ring-0">
                </label>
            </div>
        </div>
    </header>

    <section class="mt-5 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <div class="flex min-w-max gap-2">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="rounded-xl border border-zinc-700 bg-zinc-900 px-5 py-3 text-sm font-black text-zinc-100 transition hover:-translate-y-0.5 hover:border-orange-400 hover:bg-orange-500 hover:text-zinc-950">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </section>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach($featuredProducts as $product)
                <article class="overflow-hidden rounded-3xl border border-zinc-700 bg-zinc-900">
                    <div class="relative h-52">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/600x500?text=Food' }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <p class="absolute right-3 top-3 rounded-full bg-orange-500 px-3 py-1 text-xs font-black text-zinc-950">Featured</p>
                        <p class="absolute bottom-3 left-3 rounded-xl bg-red-600 px-3 py-1 text-sm font-black text-white">{{ $formatEgp((float) $product->price) }}</p>
                    </div>
                    <div class="space-y-2 p-4">
                        <h2 class="text-lg font-black text-white">{{ $product->name }}</h2>
                        <p class="line-clamp-2 text-sm text-zinc-400">{{ $product->description ?: 'وجبة بطابع حيوي وقوام مقرمش ولذيذ.' }}</p>
                        <p class="text-xs font-semibold text-zinc-500">⭐ 4.8 • Ready in 15 min</p>
                    </div>
                </article>
            @endforeach
        </section>
    @endif

    <section class="mt-8 space-y-6">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}" class="rounded-3xl border border-zinc-700 bg-zinc-900/80 p-4 backdrop-blur sm:p-6">
                    <h2 class="text-3xl font-black text-white">{{ $category->name_ar }}</h2>
                    <div class="mt-4 grid gap-3 lg:grid-cols-2">
                        @foreach($category->products as $product)
                            <article class="grid grid-cols-[1fr_auto] overflow-hidden rounded-2xl border border-zinc-700 bg-zinc-950">
                                <div class="flex gap-3 p-3">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/220x220?text=Dish' }}" class="h-20 w-20 rounded-xl object-cover" alt="{{ $product->name }}">
                                    <div>
                                        <h3 class="font-black text-white">{{ $product->name }}</h3>
                                        <p class="mt-1 line-clamp-2 text-xs text-zinc-400">{{ $product->description ?: 'صنف مليان نكهة ومناسب لعشاق السرعة.' }}</p>
                                        <p class="mt-1 text-[11px] font-semibold text-zinc-500">20 min • Highly Rated</p>
                                    </div>
                                </div>
                                <div class="flex items-center bg-orange-500 px-3 text-sm font-black text-zinc-950">{{ $formatEgp((float) $product->price) }}</div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="rounded-2xl border border-zinc-700 bg-zinc-900 p-6 text-center text-zinc-400">لا يوجد أصناف متاحة حاليًا.</div>
        @endforelse
    </section>
</main>
</body>
</html>
