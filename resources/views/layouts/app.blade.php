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
<div class="zz-shell">
    <header class="zz-card mb-6 p-4 md:p-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <a href="{{ route('dashboard') }}" class="text-xl font-extrabold text-teal-800">Za3tr-Zatona</a>
                <p class="text-xs text-slate-500">منصة منيو SaaS احترافية</p>
            </div>
            <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold">
                <a class="zz-btn-secondary" href="{{ route('dashboard') }}">لوحة التحكم</a>
                <a class="zz-btn-secondary" href="{{ route('categories.index') }}">الأقسام</a>
                <a class="zz-btn-secondary" href="{{ route('products.index') }}">المنتجات</a>
                <a class="zz-btn-secondary" href="{{ route('settings.index') }}">الإعدادات</a>
                <a class="zz-btn-secondary" href="{{ route('profile.edit') }}">الحساب</a>
                <form action="{{ route('logout') }}" method="POST">@csrf <button class="zz-btn-primary">تسجيل خروج</button></form>
            </nav>
        </div>
    </header>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $slot ?? '' }}
    @yield('content')
</div>
</body>
</html>
