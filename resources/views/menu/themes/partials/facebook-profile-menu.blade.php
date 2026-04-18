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
<body class="font-['Cairo'] {{ $pageBackgroundClass ?? 'bg-slate-100' }} {{ $bodyTextClass ?? 'text-slate-900' }}">
<main class="mx-auto w-full max-w-3xl p-2 pb-8 sm:p-4">
    <article class="overflow-hidden rounded-3xl border {{ $shellBorderClass ?? 'border-slate-200' }} {{ $shellBackgroundClass ?? 'bg-white' }} shadow-sm">
        <header>
            <div class="relative h-44 w-full overflow-hidden {{ $coverWrapClass ?? 'bg-slate-200' }}">
                <img
                    src="{{ $restaurant->banner_path ? asset('storage/'.$restaurant->banner_path) : 'https://placehold.co/1200x420?text=Restaurant+Cover' }}"
                    class="h-full w-full object-cover"
                    alt="{{ $restaurant->name }} cover"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/20 to-transparent"></div>
            </div>

            <div class="relative px-4 pb-4 pt-3 sm:px-6">
                <div class="flex items-end justify-between gap-3">
                    <div class="flex items-end gap-3">
                        <div class="-mt-16 h-28 w-28 overflow-hidden rounded-full border-4 {{ $profileBorderClass ?? 'border-white' }} bg-white shadow-md">
                            <img
                                src="{{ $restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : 'https://placehold.co/240x240?text=Logo' }}"
                                class="h-full w-full object-cover"
                                alt="{{ $restaurant->name }} logo"
                            >
                        </div>

                        <div class="pb-1">
                            <h1 class="text-xl font-extrabold sm:text-2xl {{ $titleClass ?? 'text-slate-900' }}">{{ $restaurant->name }}</h1>
                            <p class="mt-1 max-w-md text-xs sm:text-sm {{ $subtitleClass ?? 'text-slate-600' }}">{{ $restaurant->description ?: 'منيو المطعم بطريقة سهلة وسريعة.' }}</p>
                        </div>
                    </div>

                    <button class="mb-2 inline-flex h-10 w-10 items-center justify-center rounded-full border {{ $cartBorderClass ?? 'border-slate-200' }} {{ $cartBackgroundClass ?? 'bg-white' }} {{ $cartIconClass ?? 'text-slate-600' }} shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2m0 0L7 13h10l2-8H5.4Zm1.6 11a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm10 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <section class="px-4 pb-3 pt-1 sm:px-6">
            <div class="rounded-2xl border {{ $searchBorderClass ?? 'border-slate-200' }} {{ $searchBackgroundClass ?? 'bg-slate-50' }} px-3 py-2 text-sm {{ $searchTextClass ?? 'text-slate-500' }}">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                    <span>Search menu</span>
                </div>
            </div>
        </section>

        <section class="px-4 pb-4 sm:px-6">
            <h2 class="mb-3 text-sm font-bold {{ $sectionTitleClass ?? 'text-slate-700' }}">الأقسام</h2>
            <div class="-mx-1 overflow-x-auto pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex min-w-max gap-3 px-1">
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->id }}" class="group w-20 text-center">
                            <span class="mx-auto inline-flex h-16 w-16 items-center justify-center overflow-hidden rounded-full border-2 {{ $storyBorderClass ?? 'border-slate-200' }} {{ $storyBackgroundClass ?? 'bg-white' }} p-0.5 shadow-sm transition group-hover:scale-105">
                                @php
                                    $storyProduct = $category->products->first();
                                @endphp
                                <img
                                    src="{{ $storyProduct?->image_path ? asset('storage/'.$storyProduct->image_path) : 'https://placehold.co/200x200?text=+' }}"
                                    class="h-full w-full rounded-full object-cover"
                                    alt="{{ $category->name_ar }}"
                                >
                            </span>
                            <span class="mt-1 block line-clamp-1 text-xs font-semibold {{ $storyTextClass ?? 'text-slate-700' }}">{{ $category->name_ar }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="space-y-4 border-t {{ $feedBorderClass ?? 'border-slate-200' }} px-4 pb-5 pt-4 sm:px-6">
            @forelse($categories as $category)
                @if($category->products->isNotEmpty())
                    <section id="cat-{{ $category->id }}" class="rounded-2xl border {{ $categoryBlockBorderClass ?? 'border-slate-200' }} {{ $categoryBlockBackgroundClass ?? 'bg-white' }} p-3 shadow-sm sm:p-4">
                        <h3 class="mb-3 text-base font-extrabold {{ $categoryTitleClass ?? 'text-slate-900' }}">{{ $category->name_ar }}</h3>

                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach($category->products as $product)
                                <article class="overflow-hidden rounded-2xl border {{ $productCardBorderClass ?? 'border-slate-200' }} {{ $productCardBackgroundClass ?? 'bg-white' }}">
                                    <img
                                        src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/640x420?text=No+Image' }}"
                                        class="h-32 w-full object-cover"
                                        alt="{{ $product->name }}"
                                    >

                                    <div class="space-y-2 p-3">
                                        <h4 class="line-clamp-1 text-sm font-extrabold {{ $productTitleClass ?? 'text-slate-900' }}">{{ $product->name }}</h4>
                                        <p class="line-clamp-2 text-xs {{ $productDescriptionClass ?? 'text-slate-500' }}">{{ $product->description ?: 'وصف بسيط للمنتج.' }}</p>
                                        <div class="flex items-center gap-3 text-[11px] {{ $metaTextClass ?? 'text-slate-500' }}">
                                            <span class="inline-flex items-center gap-1">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $durationDotClass ?? 'bg-emerald-500' }}"></span>
                                                20 min
                                            </span>
                                            <span class="inline-flex items-center gap-1">
                                                <span class="{{ $ratingStarClass ?? 'text-amber-500' }}">★</span>
                                                4.8
                                            </span>
                                        </div>
                                        <p class="text-lg font-extrabold {{ $priceClass ?? 'text-slate-900' }}">{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @empty
                <div class="rounded-2xl border {{ $emptyBorderClass ?? 'border-slate-200' }} {{ $emptyBackgroundClass ?? 'bg-white' }} p-4 text-center text-sm {{ $emptyTextClass ?? 'text-slate-500' }}">لا يوجد أصناف متاحة حاليًا.</div>
            @endforelse
        </section>
    </article>
</main>
</body>
</html>
