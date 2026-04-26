@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="zz-card">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-[var(--zz-text-secondary)]">متابعة يومية</p>
                <h1 class="zz-title">{{ $restaurant->name }}، كل اللي محتاجه لإدارة المنيو في مكان واحد</h1>
                <p class="zz-subtitle">تابع الأصناف والأقسام، وخلّي رابط المنيو جاهز للمشاركة في ثواني.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.create') }}" class="zz-btn-primary">ضيف صنف جديد</a>
                <a href="{{ route('categories.create') }}" class="zz-btn-secondary">ضيف قسم</a>
            </div>
        </div>

        <div class="mt-7 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="zz-card-muted p-5"><p class="text-xs text-[var(--zz-text-secondary)]">عدد الأقسام</p><p class="mt-1 text-3xl font-extrabold text-[var(--zz-text-primary)]">{{ $stats['categories_count'] }}</p></div>
            <div class="zz-card-muted p-5"><p class="text-xs text-[var(--zz-text-secondary)]">إجمالي المنتجات</p><p class="mt-1 text-3xl font-extrabold text-[var(--zz-text-primary)]">{{ $stats['products_count'] }}</p></div>
            <div class="zz-card-muted p-5"><p class="text-xs text-[var(--zz-text-secondary)]">المتاح للعرض</p><p class="mt-1 text-3xl font-extrabold text-[var(--zz-text-primary)]">{{ $stats['available_products_count'] }}</p></div>
            <div class="zz-card-muted p-5"><p class="text-xs text-[var(--zz-text-secondary)]">المنتجات المميزة</p><p class="mt-1 text-3xl font-extrabold text-[var(--zz-text-primary)]">{{ $stats['featured_products_count'] }}</p></div>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-3">
        <section class="xl:col-span-2 zz-card">
            <div class="flex items-center justify-between gap-3">
                <h2 class="zz-section-title">خطوات سريعة</h2>
                <span class="zz-chip">تحديث لحظي</span>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <a class="rounded-2xl border border-[var(--zz-border)] bg-[var(--zz-white)] p-5 transition hover:bg-[var(--zz-beige-50)]" href="{{ route('products.index') }}">
                    <p class="font-bold text-[var(--zz-text-primary)]">إدارة المنتجات</p>
                    <p class="mt-1 text-xs leading-6 text-[var(--zz-text-secondary)]">راجع الأسعار والتوفر وعدّل أي صنف بسرعة.</p>
                </a>
                <a class="rounded-2xl border border-[var(--zz-border)] bg-[var(--zz-white)] p-5 transition hover:bg-[var(--zz-beige-50)]" href="{{ route('settings.index') }}">
                    <p class="font-bold text-[var(--zz-text-primary)]">إعدادات المنيو</p>
                    <p class="mt-1 text-xs leading-6 text-[var(--zz-text-secondary)]">ظبط لينك المنيو، الثيم، وحالة النشر.</p>
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
                <p class="mt-1 text-xs text-[var(--zz-text-secondary)]">انسخه أو افتحه مباشرة قدامك.</p>
                <input id="menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <button class="zz-btn-secondary" data-copy-target="#menu-link">انسخ اللينك</button>
                    <a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary">افتح المنيو</a>
                </div>
            </div>
            <div class="zz-card text-center">
                <p class="zz-section-title">QR المنيو جاهز</p>
                <p class="mt-1 text-xs text-[var(--zz-text-secondary)]">حمّله واطبعه وحطه على الطاولات.</p>
                <img src="{{ route('settings.menu.qr') }}" alt="QR" class="mx-auto mt-3 w-44 rounded-2xl border border-[var(--zz-border)] bg-white p-2">
                <a href="{{ route('settings.menu.qr') }}" download="menu-qr.svg" class="zz-btn-secondary mt-3 w-full">تحميل QR</a>
            </div>
        </aside>
    </div>
</div>
@endsection
