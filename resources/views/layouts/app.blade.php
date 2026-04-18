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
<div x-data="{ sidebarOpen: false, collapsed: false }" class="zz-layout">
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false"></div>

    <aside
        class="fixed inset-y-0 right-0 z-40 flex w-72 flex-col border-l border-slate-200 bg-white transition-transform duration-300 lg:translate-x-0"
        :class="[sidebarOpen ? 'translate-x-0' : 'translate-x-full', collapsed ? 'lg:w-24' : 'lg:w-72']"
    >
        <div class="flex h-full flex-col p-4">
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route(auth()->user()?->restaurant_id ? 'dashboard' : 'onboarding.create') }}" class="font-extrabold text-slate-900" :class="collapsed ? 'text-lg' : 'text-2xl'">Za3tr</a>
                <button @click="sidebarOpen = false" class="rounded-lg border border-slate-200 p-2 text-slate-600 lg:hidden">
                    <x-icon name="menu" class="h-4 w-4"/>
                </button>
            </div>

            @php
                $items = auth()->user()?->restaurant_id
                    ? [
                        ['route' => 'dashboard', 'label' => 'الرئيسية', 'icon' => 'home'],
                        ['route' => 'categories.index', 'label' => 'الأقسام', 'icon' => 'category'],
                        ['route' => 'products.index', 'label' => 'المنتجات', 'icon' => 'product'],
                        ['route' => 'settings.index', 'label' => 'الإعدادات', 'icon' => 'settings'],
                    ]
                    : [
                        ['route' => 'onboarding.create', 'label' => 'تجهيز الحساب', 'icon' => 'settings'],
                    ];

                if (auth()->user()?->isSuperAdmin()) {
                    $items[] = ['route' => 'owner.dashboard', 'label' => 'لوحة المالك', 'icon' => 'home'];
                }
            @endphp

            <nav class="space-y-2">
                @foreach($items as $item)
                    <a href="{{ route($item['route']) }}" class="zz-nav-link {{ request()->routeIs($item['route'].'*') ? 'zz-nav-link-active' : '' }}" @click="sidebarOpen = false">
                        <x-icon :name="$item['icon']" class="h-5 w-5"/>
                        <span x-show="!collapsed" x-transition.opacity>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto border-t border-slate-200 pt-4" x-show="!collapsed" x-transition.opacity>
                <a href="{{ route('profile.edit') }}" class="zz-nav-link">الحساب الشخصي</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button class="zz-btn-primary w-full">تسجيل خروج</button>
                </form>
            </div>
        </div>
    </aside>

    <main class="zz-main transition-all duration-300" :class="collapsed ? 'lg:pr-24' : 'lg:pr-72'">
        <header class="zz-topbar">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-3 px-4 py-4 md:px-6">
                <div class="flex items-center gap-2">
                    <button @click="sidebarOpen = true" class="rounded-xl border border-slate-200 bg-white p-2 text-slate-600 lg:hidden">
                        <x-icon name="menu" class="h-5 w-5"/>
                    </button>
                    <button @click="collapsed = !collapsed" class="hidden rounded-xl border border-slate-200 bg-white p-2 text-slate-600 lg:inline-flex">
                        <x-icon name="menu" class="h-5 w-5"/>
                    </button>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Za3tr-Zatona</p>
                        <p class="text-sm font-bold text-slate-900">لوحة التحكم</p>
                    </div>
                </div>
                <div class="text-xs font-semibold text-slate-500 md:text-sm">{{ now()->format('Y-m-d') }}</div>
            </div>
        </header>

        <div class="mx-auto w-full max-w-7xl px-4 py-6 md:px-6 md:py-8">
            @if(session('success'))
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
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
