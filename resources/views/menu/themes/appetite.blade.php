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
<body class="font-['Cairo'] bg-[#0b0b0d] text-zinc-100">
@php($formatEgp = fn (float $price) => rtrim(rtrim(number_format($price, 2, '.', ''), '0'), '.').' ج.م')
<main class="mx-auto max-w-7xl px-3 pb-12 pt-4 sm:px-6">
    <section class="overflow-hidden rounded-[2rem] border border-zinc-700 bg-zinc-950 shadow-[0_28px_70px_rgba(0,0,0,0.5)]">
        <header>
            <div class="relative h-52 sm:h-72">
                <img src="{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : 'https://placehold.co/1440x720?text=Street+Food+Cover' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent"></div>
                <span class="absolute left-4 top-4 rounded-full bg-orange-500 px-3 py-1 text-xs font-black text-zinc-950">Street Profile</span>
            </div>

            <div class="relative px-4 pb-6 sm:px-8">
                <div class="-mt-14 rounded-3xl border border-zinc-700 bg-zinc-900 p-4 shadow-xl sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div class="flex items-end gap-4">
                            <div class="h-24 w-24 overflow-hidden rounded-3xl border-4 border-zinc-900 bg-white shadow-lg sm:h-28 sm:w-28">
                                <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/220x220?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
                            </div>
                            <div class="pb-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-orange-400">Hot Taste Identity</p>
                                <h1 class="mt-1 text-3xl font-black text-white sm:text-4xl">{{ $restaurant->name }}</h1>
                                <p class="mt-2 max-w-2xl text-sm text-zinc-300">{{ $restaurant->description ?: 'هوية طعام جريئة بنكهة حيوية وسرعة خدمة عالية.' }}</p>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-orange-500/60 bg-orange-500/15 px-4 py-2 text-xs font-extrabold text-orange-300">Fire Menu • Fast Service</div>
                    </div>
                </div>
            </div>
        </header>

        <section class="px-4 pb-4 sm:px-8">
            <div class="-mx-1 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max gap-3 px-1">
                    @foreach($categories->take(7) as $category)
                        @php($storyProduct = $category->products->first())
                        <a href="#cat-{{ $category->id }}" class="w-24 shrink-0 text-center">
                            <div class="mx-auto h-16 w-16 overflow-hidden rounded-full border-2 border-zinc-700 bg-zinc-900 p-0.5 shadow-sm">
                                <img src="{{ $storyProduct?->image_path ? asset('storage/'.$storyProduct->image_path) : 'https://placehold.co/160x160?text=+' }}" class="h-full w-full rounded-full object-cover" alt="{{ $category->name_ar }}">
                            </div>
                            <p class="mt-2 line-clamp-1 text-xs font-bold text-zinc-200">{{ $category->name_ar }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-zinc-700 bg-zinc-900 px-4 py-3">
                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <input type="search" placeholder="ابحث عن برجر، فرايز، كومبو..." class="w-full border-0 bg-transparent p-0 text-sm text-zinc-100 placeholder:text-zinc-500 focus:outline-none focus:ring-0">
                </label>
            </div>

            <div class="mt-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max gap-2">
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->id }}" class="rounded-xl border border-zinc-700 bg-zinc-900 px-5 py-3 text-sm font-black text-zinc-100 transition hover:-translate-y-0.5 hover:border-orange-400 hover:bg-orange-500 hover:text-zinc-950">{{ $category->name_ar }}</a>
                    @endforeach
                </div>
            </div>
        </section>
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
