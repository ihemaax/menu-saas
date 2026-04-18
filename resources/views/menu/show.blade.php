<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | المنيو</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-['Cairo'] bg-slate-100 text-slate-900">
@php
    $formatEgp = fn (float $price) => rtrim(rtrim(number_format($price, 2, '.', ''), '0'), '.').' ج.م';
    $storyItems = collect([
        ['title' => 'عروض خاصة', 'subtitle' => 'تخفيضات اليوم'],
        ['title' => 'الأكثر طلبًا', 'subtitle' => 'اختيارات العملاء'],
        ['title' => 'وصول جديد', 'subtitle' => 'أصناف مضافة حديثًا'],
        ['title' => 'ترشيح الشيف', 'subtitle' => 'اختيار مميز'],
    ]);
@endphp
<main class="mx-auto max-w-5xl p-2 pb-10 sm:p-4">
    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="relative h-52 sm:h-64">
            <img src="{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : 'https://placehold.co/1440x640?text=Restaurant+Cover' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/55 via-slate-900/20 to-transparent"></div>
        </div>

        <div class="relative px-4 pb-5 sm:px-6">
            <div class="-mt-16 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex items-end gap-3">
                    <div class="h-28 w-28 overflow-hidden rounded-full border-4 border-white bg-white shadow-lg">
                        <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/220x220?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
                    </div>
                    <div class="pb-2">
                        <h1 class="text-2xl font-extrabold text-white drop-shadow sm:text-3xl">{{ $restaurant->name }}</h1>
                        <p class="mt-1 max-w-xl text-sm text-white/95">{{ $restaurant->description ?: 'منيو المطعم بطريقة سهلة وسريعة.' }}</p>
                    </div>
                </div>
                <div class="mb-1 flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 shadow-sm">
                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span>Menu Profile</span>
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <span>ابحث عن صنف داخل المنيو</span>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-4 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="mb-3 text-sm font-extrabold text-slate-700">Highlights</h2>
        <div class="-mx-1 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            <div class="flex min-w-max gap-3 px-1">
                @foreach($storyItems as $item)
                    <article class="w-28 shrink-0 rounded-2xl border border-slate-200 bg-gradient-to-b from-slate-50 to-white p-2 text-center">
                        <div class="mx-auto h-14 w-14 overflow-hidden rounded-full border-2 border-blue-300 bg-white p-0.5">
                            <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/140x140?text=+' }}" class="h-full w-full rounded-full object-cover" alt="story">
                        </div>
                        <p class="mt-2 text-xs font-extrabold text-slate-800">{{ $item['title'] }}</p>
                        <p class="mt-0.5 text-[10px] text-slate-500">{{ $item['subtitle'] }}</p>
                    </article>
                @endforeach

                @foreach($categories->take(4) as $category)
                    <a href="#cat-{{ $category->id }}" class="w-28 shrink-0 rounded-2xl border border-slate-200 bg-white p-2 text-center hover:border-blue-300">
                        <div class="mx-auto h-14 w-14 overflow-hidden rounded-full border-2 border-slate-200 p-0.5">
                            @php($storyProduct = $category->products->first())
                            <img src="{{ $storyProduct?->image_path ? asset('storage/'.$storyProduct->image_path) : 'https://placehold.co/140x140?text=C' }}" class="h-full w-full rounded-full object-cover" alt="{{ $category->name_ar }}">
                        </div>
                        <p class="mt-2 line-clamp-1 text-xs font-bold text-slate-700">{{ $category->name_ar }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mt-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <div class="flex min-w-max items-center gap-2">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:border-blue-400 hover:text-blue-700">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </section>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-5 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <h2 class="mb-4 text-xl font-extrabold">الأكثر طلبًا</h2>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($featuredProducts as $product)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/760x420?text=No+Image' }}" class="h-44 w-full object-cover" alt="{{ $product->name }}">
                        <div class="p-4">
                            <h3 class="text-base font-extrabold">{{ $product->name }}</h3>
                            <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ $product->description ?: 'وصف بسيط للمنتج.' }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs font-semibold text-slate-500">جاهز خلال 20 دقيقة</span>
                                <span class="text-lg font-extrabold text-blue-700">{{ $formatEgp((float) $product->price) }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-6 space-y-5">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}" class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                    <h2 class="text-xl font-extrabold">{{ $category->name_ar }}</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @foreach($category->products as $product)
                            <article class="rounded-2xl border border-slate-200 bg-white p-3">
                                <div class="flex gap-3">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/260x260?text=No+Image' }}" class="h-24 w-24 rounded-xl object-cover" alt="{{ $product->name }}">
                                    <div class="flex-1">
                                        <h3 class="font-extrabold">{{ $product->name }}</h3>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-500">{{ $product->description ?: 'وصف بسيط للمنتج.' }}</p>
                                        <div class="mt-2 flex items-center gap-2 text-[11px] text-slate-400"><span>4.8</span><span>•</span><span>20 min</span></div>
                                        <p class="mt-2 text-lg font-extrabold text-blue-700">{{ $formatEgp((float) $product->price) }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-5 text-center text-slate-500">لا يوجد منتجات متاحة حالياً.</div>
        @endforelse
    </section>
</main>
</body>
</html>
