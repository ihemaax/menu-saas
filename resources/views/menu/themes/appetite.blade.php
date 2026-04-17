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
<body class="font-['Cairo'] bg-slate-100">
<main class="mx-auto max-w-5xl p-4 pb-8">
    <header class="relative overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-br from-teal-900 via-teal-700 to-cyan-600 p-5 text-white shadow-lg">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,.25),transparent_40%)]"></div>
        <div class="relative">
            <div class="h-28 rounded-2xl border border-white/20 bg-white/10"></div>
            <div class="-mt-10 flex items-end gap-3 px-3">
                <div class="h-20 w-20 overflow-hidden rounded-2xl border-4 border-white bg-white shadow-lg">
                    <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/180x180?text=Logo' }}" class="h-full w-full object-cover" alt="{{ $restaurant->name }}">
                </div>
                <div class="pb-2">
                    <h1 class="text-2xl font-extrabold">{{ $restaurant->name }}</h1>
                    <p class="text-sm text-white/85">{{ $restaurant->description ?: 'أهلاً بيك في منيو المكان.' }}</p>
                </div>
            </div>
        </div>
    </header>

    <div class="sticky top-2 z-20 mt-4 rounded-2xl border border-slate-200 bg-white/95 p-3 backdrop-blur">
        <div class="overflow-x-auto whitespace-nowrap space-x-2 space-x-reverse pb-1">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="inline-flex rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:border-teal-400 hover:text-teal-700">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </div>

    @if($featuredProducts->isNotEmpty())
        <section class="mt-5">
            <h2 class="mb-3 text-sm font-bold text-slate-700">الأكثر طلبًا</h2>
            <div class="grid gap-3 md:grid-cols-2">
                @foreach($featuredProducts as $product)
                    <article class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                        <div class="flex gap-3">
                            <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/220x220?text=No+Image' }}" class="h-20 w-20 rounded-xl object-cover">
                            <div class="flex-1">
                                <h3 class="font-bold">{{ $product->name }}</h3>
                                <p class="mt-1 line-clamp-2 text-xs text-slate-500">{{ $product->description }}</p>
                                <p class="mt-2 text-sm font-extrabold text-teal-700">{{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-5 space-y-4">
        @forelse($categories as $category)
            @if($category->products->isNotEmpty())
                <section id="cat-{{ $category->id }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-3 text-lg font-extrabold">{{ $category->name_ar }}</h2>
                    <div class="space-y-3">
                        @foreach($category->products as $product)
                            <article class="rounded-xl border border-slate-200 p-3">
                                <div class="flex gap-3">
                                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/200x200?text=No+Image' }}" class="h-20 w-20 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h3 class="font-bold">{{ $product->name }}</h3>
                                        <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $product->description }}</p>
                                        <p class="mt-2 font-bold">{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @empty
            <div class="zz-empty">لا يوجد أصناف متاحة حاليًا.</div>
        @endforelse
    </section>
</main>
</body>
</html>
