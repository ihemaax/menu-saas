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
<main class="mx-auto max-w-4xl px-4 pb-10 pt-5 sm:px-6 sm:pt-8">
    <header class="border-b border-slate-200 pb-6">
        <div class="flex items-center gap-3">
            <div class="h-16 w-16 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/160x160?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
            </div>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight">{{ $restaurant->name }}</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $restaurant->description ?: 'منيو بسيط وواضح لعرض الأصناف.' }}</p>
            </div>
        </div>

        <div class="mt-4 rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-500">
            <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg><span>ابحث داخل المنيو</span></div>
        </div>
    </header>

    <section class="mt-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <div class="flex min-w-max gap-5 border-b border-slate-200 pb-2 text-sm font-semibold text-slate-500">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="border-b-2 border-transparent pb-2 hover:border-slate-900 hover:text-slate-900">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </section>

    <section class="mt-6 space-y-8">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}">
                    <h2 class="text-xl font-extrabold">{{ $category->name_ar }}</h2>
                    <div class="mt-3 divide-y divide-slate-200 border-y border-slate-200">
                        @foreach($category->products as $product)
                            <article class="grid grid-cols-[1fr_auto] items-start gap-4 py-4">
                                <div>
                                    <h3 class="font-bold">{{ $product->name }}</h3>
                                    <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $product->description ?: 'وصف بسيط للمنتج.' }}</p>
                                    <p class="mt-2 text-xs text-slate-400">20 min • 4.8</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-lg font-extrabold">{{ number_format($product->price, 2) }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="rounded-xl border border-slate-200 p-5 text-center text-slate-500">لا يوجد أصناف متاحة حاليًا.</div>
        @endforelse
    </section>
</main>
</body>
</html>
