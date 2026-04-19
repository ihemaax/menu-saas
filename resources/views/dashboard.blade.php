@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="zz-card">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-[#7a6b53]">متابعة يومية</p>
                <h1 class="zz-title">{{ $restaurant->name }}، كل اللي محتاجه لإدارة المنيو في مكان واحد</h1>
                <p class="zz-subtitle">تابع الأصناف والأقسام، وخلّي رابط المنيو جاهز للمشاركة في ثواني.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.create') }}" class="zz-btn-primary">ضيف صنف جديد</a>
                <a href="{{ route('categories.create') }}" class="zz-btn-secondary">ضيف قسم</a>
            </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="zz-card-muted"><p class="text-xs text-[#756b58]">عدد الأقسام</p><p class="mt-1 text-3xl font-extrabold text-[#2b3526]">{{ $stats['categories_count'] }}</p></div>
            <div class="zz-card-muted"><p class="text-xs text-[#756b58]">إجمالي المنتجات</p><p class="mt-1 text-3xl font-extrabold text-[#2b3526]">{{ $stats['products_count'] }}</p></div>
            <div class="zz-card-muted"><p class="text-xs text-[#756b58]">المتاح للعرض</p><p class="mt-1 text-3xl font-extrabold text-[#2b3526]">{{ $stats['available_products_count'] }}</p></div>
            <div class="zz-card-muted"><p class="text-xs text-[#756b58]">المنتجات المميزة</p><p class="mt-1 text-3xl font-extrabold text-[#2b3526]">{{ $stats['featured_products_count'] }}</p></div>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-3">
        <section class="xl:col-span-2 zz-card">
            <div class="flex items-center justify-between gap-3">
                <h2 class="zz-section-title">خطوات سريعة</h2>
                <span class="zz-chip">تحديث لحظي</span>
            </div>

            <div class="mt-4 grid gap-3 md:grid-cols-2">
                <a class="rounded-2xl border border-[#e3dacb] p-4 transition hover:bg-[#f8f4eb]" href="{{ route('products.index') }}">
                    <p class="font-bold text-[#2b3526]">إدارة المنتجات</p>
                    <p class="mt-1 text-xs text-[#6e695e]">راجع الأسعار والتوفر وعدّل أي صنف بسرعة.</p>
                </a>
                <a class="rounded-2xl border border-[#e3dacb] p-4 transition hover:bg-[#f8f4eb]" href="{{ route('settings.index') }}">
                    <p class="font-bold text-[#2b3526]">إعدادات المنيو</p>
                    <p class="mt-1 text-xs text-[#6e695e]">ظبط لينك المنيو، الثيم، وحالة النشر.</p>
                </a>
            </div>

            @if($stats['products_count'] === 0)
                <div class="zz-empty mt-5">
                    لسه ما ضفتش منتجات، ابدأ بأول صنف وخلي المنيو تبقى جاهزة للعرض.
                </div>
            @endif
        </section>

        <aside class="space-y-6">
            <div class="zz-card">
                <p class="zz-section-title">لينك المنيو</p>
                <p class="mt-1 text-xs text-[#6e695e]">انسخه أو افتحه مباشرة قدامك.</p>
                <input id="menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <button class="zz-btn-secondary" data-copy-target="#menu-link">انسخ اللينك</button>
                    <a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary">افتح المنيو</a>
                </div>
            </div>
            <div class="zz-card text-center">
                <p class="zz-section-title">QR المنيو جاهز</p>
                <p class="mt-1 text-xs text-[#6e695e]">حمّله واطبعه وحطه على الطاولات.</p>
                <img src="{{ route('settings.menu.qr') }}" alt="QR" class="mx-auto mt-3 w-44 rounded-2xl border border-[#e1d9ca] bg-white p-2">
                <a href="{{ route('settings.menu.qr') }}" download="menu-qr.svg" class="zz-btn-secondary mt-3 w-full">تحميل QR</a>
            </div>
        </aside>
    </div>
</div>
@endsection
