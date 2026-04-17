@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <section class="lg:col-span-2 space-y-6">
        <div class="zz-card p-6">
            <h1 class="zz-title">مرحبًا، {{ $restaurant->name }}</h1>
            <p class="zz-subtitle mt-1">لوحة تحكم متقدمة لإدارة منيو مطعمك باحتراف.</p>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">الأقسام</p><p class="text-2xl font-bold">{{ $stats['categories_count'] }}</p></div>
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">المنتجات</p><p class="text-2xl font-bold">{{ $stats['products_count'] }}</p></div>
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">منتجات متاحة</p><p class="text-2xl font-bold">{{ $stats['available_products_count'] }}</p></div>
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">منتجات مميزة</p><p class="text-2xl font-bold">{{ $stats['featured_products_count'] }}</p></div>
            </div>
        </div>

        <div class="zz-card p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-lg font-bold">إجراءات سريعة</h2>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('categories.create') }}" class="zz-btn-secondary">إضافة قسم</a>
                    <a href="{{ route('products.create') }}" class="zz-btn-primary">إضافة منتج</a>
                </div>
            </div>
            @if($stats['products_count'] === 0)
                <div class="zz-empty mt-4">لا توجد منتجات بعد. ابدأ بإضافة أول منتج الآن.</div>
            @endif
        </div>
    </section>

    <aside class="space-y-6">
        <div class="zz-card p-5">
            <h3 class="text-sm font-bold text-slate-800">رابط المنيو العام</h3>
            <input id="menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
            <div class="mt-3 flex gap-2">
                <button class="zz-btn-secondary w-full" data-copy-target="#menu-link">نسخ الرابط</button>
                <a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary w-full">معاينة</a>
            </div>
        </div>
        <div class="zz-card p-5">
            <h3 class="text-sm font-bold text-slate-800">QR Code</h3>
            <img src="{{ route('settings.menu.qr') }}" alt="QR" class="mx-auto mt-4 w-56 rounded-xl border border-slate-200 bg-white p-2">
            <a href="{{ route('settings.menu.qr') }}" download="menu-qr.svg" class="zz-btn-secondary mt-3 w-full">تحميل SVG</a>
        </div>
    </aside>
</div>
@endsection
