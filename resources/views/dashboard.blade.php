@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="zz-title">مرحباً {{ $restaurant->name }}</h1>
                <p class="zz-subtitle mt-2">نظرة سريعة على أداء المنيو وإدارة المحتوى اليومي بشكل منظم.</p>
            </div>
            <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                <a href="{{ route('products.create') }}" class="zz-btn-primary">إضافة منتج جديد</a>
                <a href="{{ route('categories.create') }}" class="zz-btn-secondary">إضافة قسم</a>
            </div>
        </div>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <article class="zz-card-soft p-4">
                <p class="text-xs font-semibold text-slate-500">الأقسام</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['categories_count'] }}</p>
            </article>
            <article class="zz-card-soft p-4">
                <p class="text-xs font-semibold text-slate-500">المنتجات</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['products_count'] }}</p>
            </article>
            <article class="zz-card-soft p-4">
                <p class="text-xs font-semibold text-slate-500">المتاح الآن</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['available_products_count'] }}</p>
            </article>
            <article class="zz-card-soft p-4">
                <p class="text-xs font-semibold text-slate-500">المنتجات المميزة</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['featured_products_count'] }}</p>
            </article>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.6fr_1fr]">
        <div class="space-y-6">
            <article class="zz-card p-5 md:p-6">
                <h2 class="zz-section-title">إدارة سريعة</h2>
                <p class="zz-subtitle mt-1">اختصارات لأكثر العمليات استخدامًا في إدارة المنيو.</p>

                <div class="mt-4 grid gap-3 md:grid-cols-2">
                    <a class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:bg-white" href="{{ route('products.index') }}">
                        <p class="font-bold text-slate-900">إدارة المنتجات</p>
                        <p class="mt-1 text-xs text-slate-500">تعديل الأسعار، الإتاحة، والعناصر المميزة.</p>
                    </a>
                    <a class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:bg-white" href="{{ route('categories.index') }}">
                        <p class="font-bold text-slate-900">إدارة الأقسام</p>
                        <p class="mt-1 text-xs text-slate-500">ترتيب الأقسام والتحكم في ظهورها.</p>
                    </a>
                    <a class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:bg-white" href="{{ route('settings.index') }}">
                        <p class="font-bold text-slate-900">إعدادات المنيو</p>
                        <p class="mt-1 text-xs text-slate-500">اللينك، حالة الظهور، وثيم العرض.</p>
                    </a>
                    <a class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:bg-white" target="_blank" href="{{ $menuUrl }}">
                        <p class="font-bold text-slate-900">معاينة المنيو</p>
                        <p class="mt-1 text-xs text-slate-500">شاهد صفحة المنيو العامة كما يراها الزبون.</p>
                    </a>
                </div>

                @if($stats['products_count'] === 0)
                    <div class="zz-empty mt-5">لا توجد منتجات بعد. ابدأ بإضافة أول منتج لبناء منيو مطعمك.</div>
                @endif
            </article>
        </div>

        <aside class="space-y-6">
            <article class="zz-card p-5">
                <h2 class="zz-section-title">لينك المنيو العام</h2>
                <p class="zz-subtitle mt-1">مشاركة مباشرة مع العملاء.</p>
                <input id="menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
                <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
                    <button class="zz-btn-secondary" data-copy-target="#menu-link">نسخ الرابط</button>
                    <a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary">فتح</a>
                </div>
            </article>

            <article class="zz-card p-5 text-center">
                <h2 class="zz-section-title">QR Menu</h2>
                <p class="zz-subtitle mt-1">جاهز للطباعة أو الإرسال للعميل.</p>
                <img src="{{ route('settings.menu.qr') }}" alt="QR" class="mx-auto mt-4 w-44 rounded-2xl border border-slate-200 bg-white p-2">
                <a href="{{ route('settings.menu.qr') }}" download="menu-qr.svg" class="zz-btn-secondary mt-4 w-full">تحميل QR</a>
            </article>
        </aside>
    </section>
</div>
@endsection
