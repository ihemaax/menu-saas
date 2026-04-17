@extends('layouts.app')

@section('content')
<div class="grid gap-6 xl:grid-cols-4">
    <section class="xl:col-span-3 space-y-6">
        <div class="zz-card p-6">
            <h1 class="zz-title">أهلاً {{ $restaurant->name }}</h1>
            <p class="zz-subtitle mt-1">ده ملخص سريع لحالة المنيو عندك النهاردة.</p>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">أقسام</p><p class="text-2xl font-extrabold">{{ $stats['categories_count'] }}</p></div>
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">كل المنتجات</p><p class="text-2xl font-extrabold">{{ $stats['products_count'] }}</p></div>
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">المتاح دلوقتي</p><p class="text-2xl font-extrabold">{{ $stats['available_products_count'] }}</p></div>
                <div class="rounded-xl bg-slate-50 p-4"><p class="text-xs text-slate-500">مميزة</p><p class="text-2xl font-extrabold">{{ $stats['featured_products_count'] }}</p></div>
            </div>
        </div>

        <div class="zz-card p-6">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('categories.create') }}" class="zz-btn-secondary">قسم جديد</a>
                <a href="{{ route('products.create') }}" class="zz-btn-primary">منتج جديد</a>
                <a href="{{ route('themes.index') }}" class="zz-btn-secondary">تغيير الثيم</a>
            </div>
            @if($stats['products_count'] === 0)
                <div class="zz-empty mt-4">لسه مفيش منتجات. نبدأ بأول صنف؟</div>
            @endif
        </div>
    </section>

    <aside class="space-y-6">
        <div class="zz-card p-5">
            <p class="text-sm font-bold">لينك المنيو</p>
            <input id="menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
            <div class="mt-3 flex gap-2"><button class="zz-btn-secondary w-full" data-copy-target="#menu-link">نسخ</button><a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary w-full">فتح</a></div>
        </div>
        <div class="zz-card p-5 text-center">
            <p class="text-sm font-bold">QR للمنيو</p>
            <img src="{{ route('settings.menu.qr') }}" alt="QR" class="mx-auto mt-3 w-48 rounded-xl border border-slate-200 bg-white p-2">
            <a href="{{ route('settings.menu.qr') }}" download="menu-qr.svg" class="zz-btn-secondary mt-3 w-full">تحميل</a>
        </div>
    </aside>
</div>
@endsection
