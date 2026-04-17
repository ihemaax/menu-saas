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
<body class="font-['Cairo'] bg-white">
<main class="mx-auto max-w-3xl p-4 md:p-6">
    <header class="mb-6 rounded-3xl border border-slate-200 bg-slate-50 p-5">
        <div class="flex items-center gap-3">
            <div class="h-16 w-16 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/140x140?text=Logo' }}" class="h-full w-full object-cover">
            </div>
            <div>
                <h1 class="text-2xl font-extrabold">{{ $restaurant->name }}</h1>
                <p class="text-sm text-slate-500">{{ $restaurant->description ?: 'منيو مرتب وسريع.' }}</p>
            </div>
        </div>
    </header>

    <section class="space-y-6">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section>
                    <h2 class="mb-3 text-lg font-extrabold">{{ $category->name_ar }}</h2>
                    <div class="space-y-2">
                        @foreach($category->products as $product)
                            <article class="flex items-start justify-between gap-3 rounded-xl border border-slate-200 p-3">
                                <div>
                                    <h3 class="font-bold">{{ $product->name }}</h3>
                                    <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $product->description }}</p>
                                </div>
                                <p class="text-sm font-bold">{{ number_format($product->price, 2) }}</p>
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
