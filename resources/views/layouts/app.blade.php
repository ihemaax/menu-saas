<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Za3tr-Zatona' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Cairo']">
<div x-data="{ collapsed: false, mobileOpen: false }" class="zz-layout">
    <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 z-30 bg-[#1f2933]/40 lg:hidden" @click="mobileOpen = false"></div>

    <aside
        :class="[collapsed ? 'lg:w-24' : 'lg:w-72', mobileOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0']"
        class="zz-sidebar w-72"
    >
        <div class="flex h-full flex-col p-3">
            <div class="mb-6 flex items-center justify-between rounded-2xl bg-[#f2ede2] px-3 py-3">
                <a href="{{ route(auth()->user()?->restaurant_id ? 'dashboard' : 'onboarding.create') }}" class="font-extrabold text-[#253126]" :class="collapsed ? 'text-lg' : 'text-2xl'">Za3tr-Zatona</a>
                <button @click="collapsed = !collapsed" class="hidden rounded-xl border border-[#d7cfbf] bg-white p-2 text-[#5f695f] hover:bg-[#f7f2e8] lg:inline-flex">
                    <x-icon name="menu" class="h-4 w-4"/>
                </button>
                <button @click="mobileOpen = false" class="rounded-xl border border-[#d7cfbf] bg-white p-2 text-[#5f695f] lg:hidden">
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
                    <a href="{{ route($item['route']) }}" class="zz-nav-link {{ request()->routeIs($item['route'].'*') ? 'zz-nav-link-active' : '' }}">
                        <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0"/>
                        <div x-show="!collapsed" class="min-w-0">
                            <p class="truncate">{{ $item['label'] }}</p>
                            <p class="text-xs opacity-75">{{ $item['hint'] }}</p>
                        </div>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto border-t border-[#ddd5c8] pt-4" x-show="!collapsed || window.innerWidth < 1024">
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
                    <button @click="mobileOpen = true" class="inline-flex rounded-xl border border-[#d7cfbf] bg-white p-2 text-[#5f695f] lg:hidden">
                        <x-icon name="menu" class="h-5 w-5"/>
                    </button>
                    <div>
                        <p class="text-xs font-semibold text-[#7d725f]">Za3tr-Zatona Admin</p>
                        <p class="text-sm font-bold text-[#2a3324]">إدارة المطعم</p>
                    </div>
                </div>
                <div class="text-sm text-[#6b665a]">{{ now()->translatedFormat('d F Y') }}</div>
            </div>
        </header>

        <div class="zz-page">
            @if(session('success'))
                <div class="rounded-2xl border border-[#c9ddb0] bg-[#eef6e1] px-4 py-3 text-sm font-semibold text-[#3f5a21]">{{ session('success') }}</div>
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
</body>
</html>
