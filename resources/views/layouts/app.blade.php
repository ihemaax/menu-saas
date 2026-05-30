<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Osirix' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zz-admin-ui font-['Cairo'] bg-[#f6f1e8] text-[#12221d]">
@php
    $authUser = auth()->user();
    $subscriptionRestaurant = $authUser?->restaurant;
    $effectiveSubscriptionStatus = $subscriptionRestaurant?->effectiveSubscriptionStatus();
    $isReadOnlyMode = $subscriptionRestaurant?->isSubscriptionReadOnly() ?? false;
    $daysRemaining = $subscriptionRestaurant?->subscriptionDaysRemaining();
    $freeTrialDays = max(1, (int) config('subscription.free_trial_days', 30));
    $subscriptionPlanLabel = $subscriptionRestaurant?->isFreeTrialSubscription() ? "تجربة مجانية {$freeTrialDays} يوم" : 'باقة مفعلة';

    $statusBadgeMap = [
        'active' => ['label' => 'شغال', 'class' => 'zz-badge-active'],
        'expired' => ['label' => 'منتهي', 'class' => 'zz-badge-muted'],
        'suspended' => ['label' => 'موقوف', 'class' => 'zz-badge-danger'],
    ];

    $statusBadge = $statusBadgeMap[$effectiveSubscriptionStatus] ?? ['label' => 'مش محدد', 'class' => 'zz-badge-muted'];

    $subscriptionMessage = match($effectiveSubscriptionStatus) {
        'active' => $daysRemaining !== null
            ? "اشتراكك شغال، فاضل {$daysRemaining} يوم."
            : 'اشتراكك شغال حالياً.',
        'expired' => 'الاشتراك منتهي. تقدر تشوف البيانات بس لحد ما يتجدد.',
        'suspended' => 'الاشتراك موقوف حالياً. التعديل مقفول مؤقتاً.',
        default => null,
    };
@endphp

<div x-data="{ collapsed: false, mobileOpen: false }" class="min-h-screen bg-[#f6f1e8]">
    <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 z-30 bg-black/60 lg:hidden" @click="mobileOpen = false"></div>

    <aside
        :class="[collapsed ? 'lg:w-20' : 'lg:w-60', mobileOpen ? '!translate-x-0' : 'translate-x-full lg:translate-x-0']"
        class="fixed inset-y-0 right-0 z-40 w-64 border-l border-[#dce4d8] bg-[#12221d] text-white shadow-[0_24px_70px_rgba(25,36,31,0.22)] transition-all duration-300"
    >
        <div class="flex h-full flex-col p-2.5">
            <div class="mb-4 flex min-h-[58px] items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.06] p-2" :class="collapsed ? 'justify-center' : 'justify-between'">
                <a
                    x-show="!collapsed"
                    x-transition.opacity
                    href="{{ route(auth()->user()?->restaurant_id ? 'dashboard' : 'onboarding.create') }}"
                    class="flex min-w-0 flex-1 items-center gap-2 rounded-2xl px-2 py-2 transition hover:bg-white/10"
                >
                    <img src="{{ asset('osirix-logo.svg') }}" alt="Osirix" class="h-10 w-10 rounded-2xl">
                    <span class="min-w-0">
                        <span class="block truncate text-lg font-black uppercase tracking-[0.16em]">Osirix</span>
                        <span class="block truncate text-[11px] font-bold text-[#b9c8bd]">منيو ديجيتال</span>
                    </span>
                </a>
                <button @click="collapsed = !collapsed" type="button" class="hidden h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/10 text-[#d9efe7] transition hover:bg-white/15 lg:inline-flex" :aria-label="collapsed ? 'وسّع القائمة' : 'صغّر القائمة'">
                    <x-icon name="menu" class="h-5 w-5"/>
                </button>
                <button @click="mobileOpen = false" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/10 text-[#d9efe7] transition hover:bg-white/15 lg:hidden" aria-label="اقفل القائمة">
                    <x-icon name="menu" class="h-5 w-5"/>
                </button>
            </div>

            @php
                $items = auth()->user()?->restaurant_id
                    ? [
                        ['route' => 'dashboard', 'label' => 'الرئيسية', 'hint' => 'ملخص سريع', 'icon' => 'home'],
                        ['route' => 'categories.index', 'label' => 'الأقسام', 'hint' => 'رتّب المنيو', 'icon' => 'category'],
                        ['route' => 'products.index', 'label' => 'الأصناف', 'hint' => 'أسعار وصور', 'icon' => 'product'],
                        ['route' => 'settings.index', 'label' => 'الإعدادات', 'hint' => 'اللينك والشكل', 'icon' => 'settings'],
                    ]
                    : [
                        ['route' => 'onboarding.create', 'label' => 'تجهيز الحساب', 'hint' => 'أول خطوة', 'icon' => 'settings'],
                    ];

                if (auth()->user()?->isSuperAdmin()) {
                    $items[] = ['route' => 'owner.dashboard', 'label' => 'لوحة المالك', 'hint' => 'الحسابات والاشتراكات', 'icon' => 'home'];
                }
            @endphp

            <nav class="space-y-2">
                @foreach($items as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @click="mobileOpen = false"
                            class="flex items-center gap-2.5 rounded-2xl px-2.5 py-2.5 text-sm font-black text-[#d9efe7] transition hover:bg-white/10 hover:text-white {{ request()->routeIs($item['route'].'*') ? 'bg-[#d55441] text-white shadow-[0_14px_30px_rgba(213,84,65,0.24)] hover:bg-[#bd4838]' : '' }}"
                        :class="collapsed ? '!gap-0 justify-center px-0' : ''"
                        :title="collapsed ? '{{ $item['label'] }}' : ''"
                    >
                        <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0"/>
                        <span x-show="!collapsed" class="min-w-0">
                            <span class="block truncate">{{ $item['label'] }}</span>
                            <span class="block truncate text-xs font-bold opacity-70">{{ $item['hint'] }}</span>
                        </span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto space-y-3 border-t border-white/10 pt-4" x-show="!collapsed || window.innerWidth < 1024">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-center rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm font-black text-[#d9efe7] transition hover:bg-white/10">الحساب والبيانات</a>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button class="w-full rounded-2xl bg-white px-4 py-3 text-sm font-black text-[#12221d] transition hover:bg-[#fbf6ec]">خروج</button>
                </form>
            </div>
        </div>
    </aside>

    <main :class="collapsed ? 'lg:mr-20' : 'lg:mr-60'" class="min-h-screen transition-all duration-300">
        <header class="sticky top-0 z-30 border-b border-[#dce4d8] bg-[#f6f1e8]/90 backdrop-blur">
            <div class="mx-auto flex w-full max-w-[1320px] items-center justify-between gap-4 px-4 py-4 md:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button @click="mobileOpen = true" class="inline-flex rounded-2xl border border-[#dce4d8] bg-white p-2.5 text-[#68766d] shadow-sm lg:hidden">
                        <x-icon name="menu" class="h-5 w-5"/>
                    </button>
                    <div>
                        <p class="text-xs font-black text-[#2f7f79]">Osirix Control</p>
                        <p class="text-sm font-black text-[#12221d]">لوحة إدارة المنيو</p>
                    </div>
                </div>
                <div class="hidden rounded-full border border-[#dce4d8] bg-white px-4 py-2 text-xs font-black text-[#68766d] shadow-sm sm:block">
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </header>

        <div class="mx-auto w-full max-w-[1320px] space-y-7 px-4 py-6 md:px-6 lg:px-8">
            @if($subscriptionRestaurant && $subscriptionMessage)
                <section class="rounded-[24px] border border-[#dce4d8] bg-white p-4 shadow-[0_14px_34px_rgba(33,43,37,0.06)] {{ $isReadOnlyMode ? 'border-[#efc5bd] bg-[#fff0ed]' : '' }}" data-subscription-read-only="{{ $isReadOnlyMode ? '1' : '0' }}">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-sm font-black text-[#12221d]">حالة الاشتراك</h2>
                                <span class="zz-badge {{ $statusBadge['class'] }}">{{ $statusBadge['label'] }}</span>
                            </div>
                            <p class="text-sm font-bold text-[#68766d]">{{ $subscriptionMessage }}</p>
                        </div>
                        <div class="grid gap-2 text-xs font-bold text-[#68766d] sm:grid-cols-3 sm:text-sm">
                            <p><span class="text-[#12221d]">الباقة:</span> {{ $subscriptionPlanLabel }}</p>
                            <p><span class="text-[#12221d]">البداية:</span> {{ $subscriptionRestaurant->subscription_starts_at?->format('Y-m-d') ?: '-' }}</p>
                            <p><span class="text-[#12221d]">النهاية:</span> {{ $subscriptionRestaurant->subscription_ends_at?->format('Y-m-d') ?: '-' }}</p>
                        </div>
                    </div>
                </section>
            @endif

            @if(session('success'))
                <div class="rounded-2xl border border-[#b7dacd] bg-[#edf9f5] px-4 py-3 text-sm font-black text-[#23625c]">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="rounded-2xl border border-[#efc5bd] bg-[#fff0ed] px-4 py-3 text-sm font-black text-[#8b3b2e]">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-[#efc5bd] bg-[#fff0ed] px-4 py-3 text-sm font-bold text-[#8b3b2e]">
                    <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>
</div>

@if($isReadOnlyMode)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('main form').forEach((form) => {
                if (form.method.toUpperCase() === 'GET' || form.action.includes('/logout')) {
                    return;
                }

                form.classList.add('opacity-60', 'pointer-events-none');

                form.querySelectorAll('button, input, select, textarea').forEach((field) => {
                    if (field.type === 'hidden') {
                        return;
                    }

                    field.disabled = true;
                });
            });
        });
    </script>
@endif
</body>
</html>
