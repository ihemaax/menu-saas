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
<body class="font-['Cairo'] bg-[#cae0df] text-slate-900">
<main class="mx-auto min-h-screen w-full max-w-md p-3 sm:p-5">
    <div class="relative overflow-hidden rounded-[2rem] border border-slate-800 bg-[#f7fbfb] shadow-[0_24px_60px_rgba(15,23,42,0.15)]">
        <header class="border-b border-slate-200/80 bg-white px-4 pb-4 pt-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-medium tracking-wide text-slate-400">Menu</p>
                    <h1 class="mt-1 text-2xl font-extrabold leading-tight">{{ $restaurant->name }}</h1>
                </div>

                <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-teal-100 bg-teal-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2m0 0L7 13h10l2-8H5.4Zm1.6 11a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm10 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" />
                    </svg>
                </button>
            </div>

            <div class="mt-4">
                <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                    <span>Search</span>
                </div>
            </div>
        </header>

        <section class="rounded-t-[2rem] bg-[#d8ecea] px-4 pb-24 pt-4">
            <div class="-mx-1 overflow-x-auto pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <nav class="flex min-w-max gap-2 px-1">
                    <a href="#all-products" class="rounded-full border border-teal-200 bg-white px-4 py-2 text-sm font-bold text-slate-900 shadow-sm">All</a>
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->id }}" class="rounded-full border border-transparent bg-white/75 px-4 py-2 text-sm font-semibold text-slate-600">
                            {{ $category->name_ar }}
                        </a>
                    @endforeach
                </nav>
            </div>

            @php
                $allProducts = $categories->flatMap(fn ($category) => $category->products);
            @endphp

            <section id="all-products" class="mt-3 grid grid-cols-2 gap-3">
                @forelse($allProducts as $product)
                    <article class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-[0_6px_16px_rgba(148,163,184,0.15)]">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/420x320?text=No+Image' }}" class="h-28 w-full object-cover" alt="{{ $product->name }}">

                        <div class="p-3">
                            <h3 class="line-clamp-1 text-sm font-bold text-slate-900">{{ $product->name }}</h3>
                            <p class="mt-1 line-clamp-1 text-xs text-slate-500">{{ $product->description ?: 'Fresh and delicious' }}</p>

                            <div class="mt-2 flex items-center gap-2 text-[11px] text-slate-500">
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                    </svg>
                                    20 min
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                                    </svg>
                                    4.8
                                </span>
                            </div>

                            <p class="mt-2 text-xl font-extrabold text-slate-900">{{ number_format($product->price, 2) }}</p>
                        </div>
                    </article>
                @empty
                    <div class="col-span-2 rounded-2xl border border-slate-200 bg-white p-4 text-center text-sm text-slate-500">لا يوجد منتجات متاحة حاليًا.</div>
                @endforelse
            </section>

            @foreach($categories as $category)
                @if($category->products->isNotEmpty())
                    <section id="cat-{{ $category->id }}" class="mt-5">
                        <h2 class="mb-2 px-1 text-sm font-bold text-slate-700">{{ $category->name_ar }}</h2>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($category->products as $product)
                                <article class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-[0_6px_16px_rgba(148,163,184,0.15)]">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/420x320?text=No+Image' }}" class="h-24 w-full object-cover" alt="{{ $product->name }}">
                                    <div class="p-3">
                                        <h3 class="line-clamp-1 text-sm font-bold">{{ $product->name }}</h3>
                                        <p class="mt-1 line-clamp-1 text-xs text-slate-500">{{ $product->description ?: 'Fresh and delicious' }}</p>
                                        <p class="mt-2 text-lg font-extrabold">{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endforeach
        </section>

        <footer class="pointer-events-none absolute inset-x-0 bottom-0 border-t border-slate-200 bg-white/95 px-8 py-3 backdrop-blur">
            <div class="flex items-center justify-between text-slate-400">
                <span class="h-1.5 w-1.5 rounded-full bg-teal-600"></span>
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 12 7.5-7.5a2.121 2.121 0 0 1 3 0L21 12M5.25 9.75V19.5A2.25 2.25 0 0 0 7.5 21.75h9A2.25 2.25 0 0 0 18.75 19.5V9.75" />
                    </svg>
                </span>
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5h9m-9 15h9m-12-3h15m-15-9h15" />
                    </svg>
                </span>
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z" />
                    </svg>
                </span>
            </div>
        </footer>
    </div>
</main>
</body>
</html>
