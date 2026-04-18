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
<body class="font-['Cairo'] bg-[#cfe5e3] text-slate-900">
<main class="mx-auto min-h-screen w-full max-w-md p-3 sm:p-5">
    <div class="overflow-hidden rounded-[2rem] border border-slate-300 bg-[#f8fcfc] shadow-[0_25px_60px_rgba(15,23,42,0.18)]">
        <header class="border-b border-slate-200 bg-white px-4 pb-4 pt-5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <div class="h-11 w-11 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/160x160?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Menu</p>
                        <h1 class="text-lg font-extrabold leading-tight">{{ $restaurant->name }}</h1>
                    </div>
                </div>
                <button class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-teal-200 bg-teal-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2m0 0L7 13h10l2-8H5.4Zm1.6 11a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm10 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" /></svg>
                </button>
            </div>
            <p class="mt-2 line-clamp-1 text-xs text-slate-500">{{ $restaurant->description ?: 'تصفح الأصناف بسرعة وسهولة.' }}</p>
        </header>

        <section class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 px-4 py-3 backdrop-blur">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <span>Search</span>
                </div>
            </div>
            <div class="-mx-1 mt-3 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max gap-2 px-1">
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->id }}" class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700">{{ $category->name_ar }}</a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="space-y-5 bg-[#e4f3f1] px-4 pb-6 pt-4">
            @forelse($categories as $category)
                @if($category->products->isNotEmpty())
                    <section id="cat-{{ $category->id }}">
                        <h2 class="mb-3 text-sm font-extrabold text-slate-700">{{ $category->name_ar }}</h2>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($category->products as $product)
                                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/420x300?text=No+Image' }}" class="h-28 w-full object-cover" alt="{{ $product->name }}">
                                    <div class="p-3">
                                        <h3 class="line-clamp-1 text-sm font-extrabold">{{ $product->name }}</h3>
                                        <p class="mt-1 line-clamp-1 text-xs text-slate-500">{{ $product->description ?: 'Fresh & tasty' }}</p>
                                        <div class="mt-2 flex items-center gap-2 text-[11px] text-slate-500"><span>20 min</span><span>•</span><span>4.8</span></div>
                                        <p class="mt-2 text-lg font-extrabold text-slate-900">{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center text-sm text-slate-500">لا يوجد أصناف متاحة حاليًا.</div>
            @endforelse
        </section>
    </div>
</main>
</body>
</html>
