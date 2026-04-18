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
<div x-data="{ collapsed: false }" class="zz-layout" dir="ltr">
    <aside :class="collapsed ? 'w-20' : 'w-72'" class="zz-sidebar">
        <div class="h-full p-3" dir="rtl">
            <div class="mb-8 flex items-center justify-between px-2">
                <a href="{{ route(auth()->user()?->restaurant_id ? 'dashboard' : 'onboarding.create') }}" class="font-extrabold text-slate-900" :class="collapsed ? 'text-lg' : 'text-2xl'">Za3tr</a>
                <button @click="collapsed = !collapsed" class="rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-50">
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
                    <a href="{{ route($item['route']) }}" class="zz-nav-link {{ request()->routeIs($item['route'].'*') ? 'zz-nav-link-active' : '' }}">
                        <x-icon :name="$item['icon']" class="h-5 w-5"/>
                        <span x-show="!collapsed">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-8 border-t border-slate-200 pt-4" x-show="!collapsed">
                <a href="{{ route('profile.edit') }}" class="zz-nav-link">الحساب</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">@csrf <button class="w-full rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">تسجيل خروج</button></form>
            </div>
        </div>
    </aside>

    <main :class="collapsed ? 'ml-20' : 'ml-72'" class="zz-main" dir="rtl">
        <header class="zz-topbar">
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500">Za3tr-Zatona Control</p>
                    <p class="text-sm font-bold text-slate-900">لوحة التحكم</p>
                </div>
                <div class="text-sm text-slate-500">{{ now()->format('d M Y') }}</div>
            </div>
        </header>

        <div class="p-4 md:p-6 lg:p-8">
            @if(session('success'))<div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
