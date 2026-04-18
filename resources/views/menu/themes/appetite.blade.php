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
<body class="font-['Cairo'] bg-zinc-950 text-zinc-100">
<main class="mx-auto max-w-6xl p-3 pb-10 sm:p-6">
    <header class="rounded-3xl border border-zinc-800 bg-gradient-to-br from-zinc-950 via-zinc-900 to-red-950 p-4 shadow-2xl sm:p-6">
        <div class="grid gap-4 sm:grid-cols-[1fr_auto] sm:items-center">
            <div>
                <div class="inline-flex rounded-full border border-red-500/40 bg-red-600/15 px-3 py-1 text-xs font-bold text-red-200">Street Menu</div>
                <h1 class="mt-3 text-3xl font-black tracking-tight text-white sm:text-4xl">{{ $restaurant->name }}</h1>
                <p class="mt-2 max-w-2xl text-sm text-zinc-300">{{ $restaurant->description ?: 'نكهات قوية وتجربة سريعة وممتعة.' }}</p>
            </div>
            <div class="h-20 w-20 overflow-hidden rounded-2xl border-2 border-red-400/50 bg-zinc-100 shadow-lg sm:h-24 sm:w-24">
                <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/200x200?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
            </div>
        </div>

        <div class="mt-5 grid gap-3 sm:grid-cols-[1fr_auto]">
            <div class="rounded-2xl border border-zinc-700 bg-zinc-900 px-4 py-3 text-sm text-zinc-400">
                <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg><span>ابحث عن منتج</span></div>
            </div>
            <button class="rounded-2xl border border-red-500 bg-red-600 px-5 py-3 text-sm font-extrabold text-white">عروض اليوم</button>
        </div>
    </header>

    <section class="mt-5">
        <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="rounded-2xl border border-zinc-700 bg-zinc-900 px-3 py-3 text-center text-sm font-bold text-zinc-200 transition hover:border-red-500 hover:text-white">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </section>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-6">
            <h2 class="mb-3 text-xl font-black text-white">الأكثر طلبًا</h2>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach($featuredProducts as $product)
                    <article class="relative overflow-hidden rounded-3xl border border-zinc-700 bg-zinc-900">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/520x520?text=No+Image' }}" class="h-52 w-full object-cover opacity-85" alt="{{ $product->name }}">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/65 to-transparent p-4">
                            <h3 class="font-extrabold text-white">{{ $product->name }}</h3>
                            <p class="mt-1 line-clamp-1 text-xs text-zinc-300">{{ $product->description ?: 'وصف مختصر للمنتج.' }}</p>
                            <p class="mt-2 inline-flex rounded-full bg-red-600 px-3 py-1 text-sm font-extrabold text-white">{{ number_format($product->price, 2) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-7 space-y-5">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}" class="rounded-3xl border border-zinc-700 bg-zinc-900 p-4 sm:p-5">
                    <h2 class="text-2xl font-black text-white">{{ $category->name_ar }}</h2>
                    <div class="mt-4 grid gap-3 md:grid-cols-2">
                        @foreach($category->products as $product)
                            <article class="flex gap-3 rounded-2xl border border-zinc-700 bg-zinc-950 p-3">
                                <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/240x240?text=No+Image' }}" class="h-24 w-24 rounded-xl object-cover" alt="{{ $product->name }}">
                                <div class="flex-1">
                                    <h3 class="font-extrabold text-white">{{ $product->name }}</h3>
                                    <p class="mt-1 line-clamp-2 text-xs text-zinc-400">{{ $product->description ?: 'وصف بسيط للمنتج.' }}</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-[11px] font-semibold text-zinc-500">جاهز خلال 20 دقيقة</span>
                                        <span class="text-lg font-black text-red-400">{{ number_format($product->price, 2) }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="rounded-2xl border border-zinc-700 bg-zinc-900 p-5 text-center text-zinc-400">لا يوجد أصناف متاحة حاليًا.</div>
        @endforelse
    </section>
</main>
</body>
</html>
