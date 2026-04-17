<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net"><link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-['Cairo'] bg-teal-50/50">
<main class="mx-auto max-w-4xl p-4">
    <header class="zz-card p-4 sticky top-3 z-20">
        <div class="flex items-center gap-3">
            <img src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/80x80?text=Logo' }}" class="h-14 w-14 rounded-xl object-cover">
            <div><h1 class="font-extrabold">{{ $restaurant->name }}</h1><p class="text-xs text-slate-500">{{ $restaurant->description ?: 'أهلاً بيك في المنيو' }}</p></div>
        </div>
        <div class="mt-3 overflow-x-auto whitespace-nowrap space-x-2 space-x-reverse pb-1">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="zz-chip inline-block">{{ $category->name_ar }}</a>
            @endforeach
        </div>
    </header>

    @if($featuredProducts->isNotEmpty())
    <section class="mt-4"><h2 class="mb-2 px-1 text-sm font-bold text-slate-700">الأكثر طلبًا</h2>
        <div class="grid gap-3 sm:grid-cols-2">
            @foreach($featuredProducts as $p)
                <div class="zz-card p-3 flex gap-3">
                    <img src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://placehold.co/160x160?text=No+Image' }}" class="h-16 w-16 rounded-lg object-cover">
                    <div class="flex-1"><h3 class="font-bold text-sm">{{ $p->name }}</h3><p class="text-xs text-slate-500 line-clamp-2">{{ $p->description }}</p><p class="mt-1 text-sm font-bold text-teal-700">{{ number_format($p->price,2) }}</p></div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <section class="mt-4 space-y-4">
        @forelse($categories as $cat)
            @if($cat->products->isNotEmpty())
            <div id="cat-{{ $cat->id }}" class="zz-card p-4"><h2 class="mb-3 font-extrabold">{{ $cat->name_ar }}</h2>
                <div class="space-y-3">@foreach($cat->products as $p)
                    <article class="flex gap-3 rounded-xl border border-slate-200 p-3">
                        <img src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://placehold.co/180x180?text=No+Image' }}" class="h-20 w-20 rounded-lg object-cover">
                        <div class="flex-1"><h3 class="font-bold">{{ $p->name }}</h3><p class="text-sm text-slate-500 line-clamp-2">{{ $p->description }}</p><p class="mt-1 font-bold">{{ number_format($p->price,2) }}</p></div>
                    </article>
                @endforeach</div>
            </div>
            @endif
        @empty
            <div class="zz-empty">مفيش أصناف متاحة حاليًا.</div>
        @endforelse
    </section>
</main>
</body>
</html>
