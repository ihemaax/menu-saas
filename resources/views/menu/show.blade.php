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
<body class="font-['Cairo'] bg-slate-50">
<main class="mx-auto max-w-5xl p-4 md:p-8">
    <header class="zz-card p-6 text-center">
        <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/120x120?text=Logo' }}" class="mx-auto h-24 w-24 rounded-2xl object-cover" alt="{{ $restaurant->name }}">
        <h1 class="mt-4 text-3xl font-extrabold">{{ $restaurant->name }}</h1>
        <p class="mt-2 text-slate-500">{{ $restaurant->description ?: 'منيو رقمي سريع وسهل التصفح.' }}</p>
    </header>

    @if($featuredProducts->isNotEmpty())
    <section class="mt-6">
        <h2 class="mb-3 text-lg font-bold">⭐ المنتجات المميزة</h2>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($featuredProducts as $product)
                <div class="zz-card p-4">
                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/500x320?text=No+Image' }}" class="h-32 w-full rounded-xl object-cover">
                    <h3 class="mt-3 font-bold">{{ $product->name }}</h3>
                    <p class="text-sm text-slate-500">{{ number_format($product->price, 2) }}</p>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <section class="mt-6 space-y-6">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <div class="zz-card p-5">
                    <h2 class="text-xl font-bold">{{ $category->name_ar }}</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @foreach($category->products as $product)
                            <article class="rounded-xl border border-slate-200 bg-white p-4">
                                <div class="flex gap-3">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/240x240?text=No+Image' }}" class="h-20 w-20 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h3 class="font-bold">{{ $product->name }}</h3>
                                        <p class="line-clamp-2 text-sm text-slate-500">{{ $product->description }}</p>
                                        <p class="mt-2 text-sm font-bold text-teal-700">{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
            <div class="zz-empty">لا يوجد منتجات متاحة حالياً.</div>
        @endforelse
    </section>
</main>
</body>
</html>
