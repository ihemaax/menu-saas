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
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Cairo']">
@php
    $authUser = auth()->user();
    $subscriptionRestaurant = $authUser?->restaurant;
    $effectiveSubscriptionStatus = $subscriptionRestaurant?->effectiveSubscriptionStatus();
    $isReadOnlyMode = $subscriptionRestaurant?->isSubscriptionReadOnly() ?? false;
    $daysRemaining = $subscriptionRestaurant?->subscriptionDaysRemaining();
    $freeTrialDays = max(1, (int) config('subscription.free_trial_days', 30));
    $subscriptionPlanLabel = $subscriptionRestaurant?->isFreeTrialSubscription() ? "باقة مجانية ({$freeTrialDays} يوم)" : 'باقة مفعلة';

    $statusBadgeMap = [
        'active' => ['label' => 'نشط', 'class' => 'zz-badge-active'],
        'expired' => ['label' => 'منتهي', 'class' => 'zz-badge-muted'],
        'suspended' => ['label' => 'موقوف', 'class' => 'zz-badge-danger'],
    ];

    $statusBadge = $statusBadgeMap[$effectiveSubscriptionStatus] ?? ['label' => 'غير محدد', 'class' => 'zz-badge-muted'];

    $subscriptionMessage = match($effectiveSubscriptionStatus) {
        'active' => $daysRemaining !== null
            ? "اشتراكك نشط، متبقي {$daysRemaining} يوم على الانتهاء."
            : 'اشتراكك نشط حالياً.',
        'expired' => 'اشتراكك منتهي، تقدر تستعرض البيانات فقط لحد ما يتم التجديد.',
        'suspended' => 'اشتراكك موقوف حالياً، تقدر تدخل وتراجع البيانات فقط.',
        default => null,
    };
@endphp

<div x-data="{ collapsed: false, mobileOpen: false }" class="zz-layout">
    <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 z-30 bg-black/60 lg:hidden" @click="mobileOpen = false"></div>

    <aside
        :class="[collapsed ? 'lg:w-24' : 'lg:w-72', mobileOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0']"
        class="zz-sidebar w-72"
    >
        <div class="flex h-full flex-col p-3">
            <div class="zz-sidebar-header" :class="collapsed ? 'justify-center' : 'justify-between'">
                <a
                    x-show="!collapsed"
                    x-transition.opacity
                    href="{{ route(auth()->user()?->restaurant_id ? 'dashboard' : 'onboarding.create') }}"
                    class="zz-brand"
                >
                    <span class="zz-brand-mark">𓂀</span>
                    <span class="zz-brand-name">Osirix</span>
                </a>
                <button @click="collapsed = !collapsed" type="button" class="zz-sidebar-toggle hidden lg:inline-flex" :aria-label="collapsed ? 'توسيع القائمة الجانبية' : 'طي القائمة الجانبية'">
                    <x-icon name="menu" class="h-4 w-4"/>
                </button>
                <button @click="mobileOpen = false" type="button" class="zz-sidebar-toggle lg:hidden" aria-label="إغلاق القائمة الجانبية">
                    <x-icon name="menu" class="h-4 w-4"/>
                </button>
            </div>

            @php
                $items = auth()->user()?->restaurant_id
                    ? [
                        ['route' => 'dashboard', 'label' => 'الرئيسية', 'hint' => 'ملخص سريع', 'icon' => 'home'],
                        ['route' => 'categories.index', 'label' => 'الأقسام', 'hint' => 'تنظيم المنيو', 'icon' => 'category'],
                        ['route' => 'products.index', 'label' => 'المنتجات', 'hint' => 'إدارة الأصناف', 'icon' => 'product'],
                        ['route' => 'settings.index', 'label' => 'الإعدادات', 'hint' => 'الهوية واللينك', 'icon' => 'settings'],
                    ]
                    : [
                        ['route' => 'onboarding.create', 'label' => 'تجهيز الحساب', 'hint' => 'خطوة البداية', 'icon' => 'settings'],
                    ];

                if (auth()->user()?->isSuperAdmin()) {
                    $items[] = ['route' => 'owner.dashboard', 'label' => 'لوحة المالك', 'hint' => 'المطاعم والاشتراكات', 'icon' => 'home'];
                }
            @endphp

            <nav class="space-y-2">
                @foreach($items as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="zz-nav-link {{ request()->routeIs($item['route'].'*') ? 'zz-nav-link-active' : '' }}"
                        :class="collapsed ? '!gap-0 justify-center px-0' : ''"
                        :title="collapsed ? '{{ $item['label'] }}' : ''"
                    >
                        <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0"/>
                        <div x-show="!collapsed" class="min-w-0">
                            <p class="truncate">{{ $item['label'] }}</p>
                            <p class="text-xs opacity-75">{{ $item['hint'] }}</p>
                        </div>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto border-t border-[var(--zz-border)] pt-4" x-show="!collapsed || window.innerWidth < 1024">
                <a href="{{ route('profile.edit') }}" class="zz-nav-link">الحساب والبيانات</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">@csrf
                    <button class="zz-btn-secondary w-full">تسجيل الخروج</button>
                </form>
            </div>
        </div>
    </aside>

    <main :class="collapsed ? 'lg:mr-24' : 'lg:mr-72'" class="zz-main">
        <header class="zz-topbar">
            <div class="mx-auto flex w-full max-w-[1300px] items-center justify-between px-4 py-4 md:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button @click="mobileOpen = true" class="inline-flex rounded-xl border border-[var(--zz-border)] bg-[var(--zz-white)] p-2 text-[var(--zz-text-secondary)] lg:hidden">
                        <x-icon name="menu" class="h-5 w-5"/>
                    </button>
                    <div>
                        <p class="text-xs font-semibold text-[var(--zz-text-secondary)]">Osirix Control Hub</p>
                        <p class="text-sm font-bold text-[var(--zz-text-primary)]">لوحة إدارة المطعم</p>
                    </div>
                </div>
                <div class="text-sm text-[var(--zz-text-secondary)]">{{ now()->translatedFormat('d F Y') }}</div>
            </div>
        </header>

        <div class="zz-page">
            @if($subscriptionRestaurant && $subscriptionMessage)
                <section class="zz-subscription-banner {{ $isReadOnlyMode ? 'zz-subscription-banner-warning' : '' }}" data-subscription-read-only="{{ $isReadOnlyMode ? '1' : '0' }}">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-sm font-bold text-[var(--zz-text-primary)]">حالة الاشتراك</h2>
                                <span class="zz-badge {{ $statusBadge['class'] }}">{{ $statusBadge['label'] }}</span>
                            </div>
                            <p class="text-sm text-[var(--zz-text-secondary)]">{{ $subscriptionMessage }}</p>
                        </div>
                        <div class="grid gap-2 text-xs text-[var(--zz-text-secondary)] sm:grid-cols-3 sm:text-sm">
                            <p><span class="font-semibold">الباقة:</span> {{ $subscriptionPlanLabel }}</p>
                            <p><span class="font-semibold">البداية:</span> {{ $subscriptionRestaurant->subscription_starts_at?->format('Y-m-d') ?: '-' }}</p>
                            <p><span class="font-semibold">النهاية:</span> {{ $subscriptionRestaurant->subscription_ends_at?->format('Y-m-d') ?: '-' }}</p>
                            <p class="sm:col-span-3"><span class="font-semibold">المتبقي:</span> {{ $daysRemaining !== null ? $daysRemaining.' يوم' : '-' }}</p>
                        </div>
                    </div>
                </section>
            @endif

            @if(session('success'))
                <div class="rounded-2xl border border-[#c9ddb0] bg-[#eef6e1] px-4 py-3 text-sm font-semibold text-[#3f5a21]">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="rounded-2xl border border-[#efc5bd] bg-[#fbe9e5] px-4 py-3 text-sm font-semibold text-[#8b3b2e]">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-[#efc5bd] bg-[#fbe9e5] px-4 py-3 text-sm text-[#8b3b2e]">
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
