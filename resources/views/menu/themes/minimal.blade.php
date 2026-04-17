<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>{{ $restaurant->name }}</title><link rel="preconnect" href="https://fonts.bunny.net"><link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />@vite(['resources/css/app.css'])</head>
<body class="font-['Cairo'] bg-white"><main class="mx-auto max-w-3xl p-4"><header class="mb-5 border-b border-slate-200 pb-4"><h1 class="text-2xl font-extrabold">{{ $restaurant->name }}</h1><p class="text-sm text-slate-500">{{ $restaurant->description ?: 'منيو المكان' }}</p></header>
@forelse($categories as $cat)
    @if($cat->products->isNotEmpty())
    <section class="mb-6"><h2 class="mb-3 text-lg font-bold">{{ $cat->name_ar }}</h2><div class="space-y-2">@foreach($cat->products as $p)<article class="flex items-start justify-between gap-3 rounded-xl border border-slate-200 p-3"><div><h3 class="font-bold">{{ $p->name }}</h3><p class="text-xs text-slate-500 line-clamp-2">{{ $p->description }}</p></div><div class="text-sm font-bold">{{ number_format($p->price,2) }}</div></article>@endforeach</div></section>
    @endif
@empty
<div class="zz-empty">المنيو فاضي حاليًا.</div>
@endforelse
</main></body></html>
