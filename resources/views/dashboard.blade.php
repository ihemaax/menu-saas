@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="zz-card p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="zz-title">صباح الخير، {{ $restaurant->name }}</h1>
                <p class="zz-subtitle mt-1">كل مؤشرات المنيو قدامك بشكل واضح.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('products.create') }}" class="zz-btn-primary">إضافة منتج</a>
                <a href="{{ route('categories.create') }}" class="zz-btn-secondary">إضافة قسم</a>
            </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4"><p class="text-xs text-slate-500">الأقسام</p><p class="mt-1 text-3xl font-extrabold">{{ $stats['categories_count'] }}</p></div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4"><p class="text-xs text-slate-500">المنتجات</p><p class="mt-1 text-3xl font-extrabold">{{ $stats['products_count'] }}</p></div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4"><p class="text-xs text-slate-500">المتاح الآن</p><p class="mt-1 text-3xl font-extrabold">{{ $stats['available_products_count'] }}</p></div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4"><p class="text-xs text-slate-500">المميز</p><p class="mt-1 text-3xl font-extrabold">{{ $stats['featured_products_count'] }}</p></div>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-3">
        <section class="xl:col-span-2 zz-card p-6">
            <h2 class="text-lg font-bold">خطوات سريعة</h2>
            <div class="mt-4 grid gap-3 md:grid-cols-3">
                <a class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50" href="{{ route('products.index') }}"><p class="font-bold">إدارة المنتجات</p><p class="text-xs text-slate-500 mt-1">راجع الأسعار والتوفر</p></a>
                <a class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50" href="{{ route('themes.index') }}"><p class="font-bold">اختيار ثيم</p><p class="text-xs text-slate-500 mt-1">غيّر شكل المنيو</p></a>
                <a class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50" href="{{ route('settings.index') }}"><p class="font-bold">إعدادات المنيو</p><p class="text-xs text-slate-500 mt-1">لينك + إظهار/إخفاء</p></a>
            </div>
            @if($stats['products_count'] === 0)
                <div class="zz-empty mt-5">لسه مفيش منتجات مضافة. أضف أول منتج وابدأ العرض.</div>
            @endif
        </section>

        <aside class="space-y-6">
            <div class="zz-card p-5">
                <p class="text-sm font-bold">لينك المنيو</p>
                <input id="menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <button class="zz-btn-secondary" data-copy-target="#menu-link">نسخ</button>
                    <a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary">فتح</a>
                </div>
            </div>
            <div class="zz-card p-5 text-center">
                <p class="text-sm font-bold">QR جاهز للطباعة</p>
                <img src="{{ route('settings.menu.qr') }}" alt="QR" class="mx-auto mt-3 w-44 rounded-xl border border-slate-200 bg-white p-2">
                <a href="{{ route('settings.menu.qr') }}" download="menu-qr.svg" class="zz-btn-secondary mt-3 w-full">تحميل QR</a>
            </div>
        </aside>
    </div>
</div>
@endsection
