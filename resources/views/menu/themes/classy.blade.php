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
<body class="font-['Cairo'] bg-stone-100 text-stone-900">
<main class="mx-auto max-w-6xl p-3 pb-10 sm:p-6">
    <header class="overflow-hidden rounded-[2rem] border border-stone-300 bg-stone-900 text-stone-100 shadow-xl">
        <div class="relative h-52 sm:h-64">
            <img src="{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : 'https://placehold.co/1440x620?text=Luxury+Cover' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} banner">
            <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-900/60 to-stone-800/20"></div>
        </div>

        <div class="relative px-4 pb-7 sm:px-8">
            <div class="-mt-14 flex flex-col items-center text-center">
                <div class="h-28 w-28 overflow-hidden rounded-full border-4 border-stone-100 bg-stone-100 shadow-xl">
                    <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/240x240?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }} logo">
                </div>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight">{{ $restaurant->name }}</h1>
                <p class="mt-2 max-w-2xl text-sm text-stone-200">{{ $restaurant->description ?: 'تجربة طعام راقية بتفاصيل هادئة.' }}</p>
            </div>

            <div class="mx-auto mt-6 max-w-2xl rounded-2xl border border-stone-600 bg-stone-800/80 px-4 py-3 text-sm text-stone-300 backdrop-blur">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <span>ابحث داخل المنيو</span>
                </div>
            </div>
        </div>
    </header>

    <section class="mt-5 overflow-x-auto border-b border-stone-300 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <div class="flex min-w-max items-center gap-6 px-2 text-sm font-semibold text-stone-500">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="border-b-2 border-transparent pb-2 transition hover:border-amber-700 hover:text-stone-900">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </section>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-6">
            <h2 class="mb-4 text-xl font-extrabold text-stone-900">اختيارات الشيف</h2>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($featuredProducts as $product)
                    <article class="overflow-hidden rounded-3xl border border-stone-300 bg-white shadow-sm">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/720x420?text=No+Image' }}" class="h-48 w-full object-cover" alt="{{ $product->name }}">
                        <div class="space-y-2 p-5">
                            <h3 class="text-lg font-extrabold">{{ $product->name }}</h3>
                            <p class="line-clamp-2 text-sm text-stone-600">{{ $product->description ?: 'وصف مختصر للمنتج.' }}</p>
                            <p class="text-xl font-extrabold text-amber-700">{{ number_format($product->price, 2) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-7 space-y-5">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}" class="rounded-3xl border border-stone-300 bg-white p-4 shadow-sm sm:p-6">
                    <h2 class="text-2xl font-extrabold text-stone-900">{{ $category->name_ar }}</h2>
                    <div class="mt-5 space-y-3">
                        @foreach($category->products as $product)
                            <article class="flex flex-col gap-4 rounded-2xl border border-stone-200 p-3 sm:flex-row sm:items-center">
                                <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/260x260?text=No+Image' }}" class="h-28 w-full rounded-2xl object-cover sm:h-24 sm:w-24" alt="{{ $product->name }}">
                                <div class="flex-1">
                                    <h3 class="font-extrabold">{{ $product->name }}</h3>
                                    <p class="mt-1 line-clamp-2 text-sm text-stone-600">{{ $product->description ?: 'وصف بسيط للمنتج.' }}</p>
                                </div>
                                <p class="text-lg font-extrabold text-amber-700">{{ number_format($product->price, 2) }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="rounded-2xl border border-stone-300 bg-white p-5 text-center text-stone-500">لا يوجد أصناف متاحة حاليًا.</div>
        @endforelse
    </section>
</main>
</body>
</html>
