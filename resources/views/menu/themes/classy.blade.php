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
<main class="mx-auto max-w-6xl p-4 md:p-8">
    <header class="relative overflow-hidden rounded-3xl border border-amber-200 bg-gradient-to-br from-stone-950 via-stone-900 to-stone-800 p-8 text-amber-100 shadow-xl">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(245,158,11,.35),transparent_45%)]"></div>
        <div class="relative">
            <div class="h-32 rounded-2xl border border-amber-200/30 bg-white/5"></div>
            <div class="-mt-12 flex items-end gap-4 px-4">
                <div class="h-24 w-24 overflow-hidden rounded-2xl border-4 border-amber-100 bg-white shadow-lg">
                    <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/200x200?text=Logo' }}" class="h-full w-full object-cover">
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold">{{ $restaurant->name }}</h1>
                    <p class="mt-1 text-sm text-amber-100/80">{{ $restaurant->description ?: 'تجربة ذوق هادية.' }}</p>
                </div>
            </div>
        </div>
    </header>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-7">
            <h2 class="mb-4 text-lg font-bold">اختيارات مميزة</h2>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach($featuredProducts as $product)
                    <article class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/640x420?text=No+Image' }}" class="h-40 w-full object-cover">
                        <div class="p-4">
                            <h3 class="font-bold">{{ $product->name }}</h3>
                            <p class="mt-1 text-sm text-stone-500 line-clamp-2">{{ $product->description }}</p>
                            <p class="mt-3 text-sm font-bold">{{ number_format($product->price, 2) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-7 space-y-5">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <h2 class="text-xl font-extrabold">{{ $category->name_ar }}</h2>
                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        @foreach($category->products as $product)
                            <article class="rounded-xl border border-stone-200 p-4">
                                <div class="flex gap-3">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/200x200?text=No+Image' }}" class="h-16 w-16 rounded-lg object-cover">
                                    <div>
                                        <h3 class="font-bold">{{ $product->name }}</h3>
                                        <p class="mt-1 text-xs text-stone-500 line-clamp-2">{{ $product->description }}</p>
                                        <p class="mt-2 text-sm font-bold">{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="zz-empty">لا يوجد أصناف متاحة.</div>
        @endforelse
    </section>
</main>
</body>
</html>
