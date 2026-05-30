@extends('layouts.app')

@section('content')
@php
    $maxVisitChart = max(1, (int) $visitChart->max('total'));
    $todayVisitsChange = $visitStats['today'] - $visitStats['yesterday'];
@endphp

<div class="space-y-5">
    <section class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_12px_28px_rgba(33,43,37,0.05)]">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-black text-[#2f7f79]">الرئيسية</p>
                <h1 class="mt-1 text-2xl font-black leading-tight text-[#12221d]">{{ $restaurant->name }}</h1>
                <p class="mt-1 text-sm font-semibold text-[#68766d]">ملخص سريع للمنيو والزيارات.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.create') }}" class="rounded-2xl bg-[#d55441] px-4 py-2.5 text-xs font-black text-white transition hover:bg-[#bd4838]">صنف جديد</a>
                <a target="_blank" href="{{ $menuUrl }}" class="rounded-2xl bg-[#12221d] px-4 py-2.5 text-xs font-black text-white transition hover:bg-[#1f3a33]">افتح المنيو</a>
            </div>
        </div>
    </section>

    <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-[22px] border border-[#dce4d8] bg-white p-4 shadow-[0_10px_24px_rgba(33,43,37,0.04)]">
            <p class="text-xs font-black text-[#68766d]">الأقسام</p>
            <p class="mt-2 text-2xl font-black text-[#12221d]">{{ $stats['categories_count'] }}</p>
        </article>
        <article class="rounded-[22px] border border-[#dce4d8] bg-white p-4 shadow-[0_10px_24px_rgba(33,43,37,0.04)]">
            <p class="text-xs font-black text-[#68766d]">الأصناف</p>
            <p class="mt-2 text-2xl font-black text-[#12221d]">{{ $stats['products_count'] }}</p>
        </article>
        <article class="rounded-[22px] border border-[#dce4d8] bg-white p-4 shadow-[0_10px_24px_rgba(33,43,37,0.04)]">
            <p class="text-xs font-black text-[#68766d]">ظاهر للعميل</p>
            <p class="mt-2 text-2xl font-black text-[#2f7f79]">{{ $stats['available_products_count'] }}</p>
        </article>
        <article class="rounded-[22px] border border-[#dce4d8] bg-white p-4 shadow-[0_10px_24px_rgba(33,43,37,0.04)]">
            <p class="text-xs font-black text-[#68766d]">مميز</p>
            <p class="mt-2 text-2xl font-black text-[#d55441]">{{ $stats['featured_products_count'] }}</p>
        </article>
    </section>

    <div class="grid gap-5 xl:grid-cols-[1fr_360px]">
        <section class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_12px_28px_rgba(33,43,37,0.05)]">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-black text-[#2f7f79]">زيارات المنيو</p>
                    <h2 class="mt-1 text-lg font-black text-[#12221d]">آخر حركة على المنيو</h2>
                </div>
                <span class="rounded-full px-3 py-1.5 text-xs font-black {{ $todayVisitsChange >= 0 ? 'bg-[#edf9f5] text-[#23625c]' : 'bg-[#fff0ed] text-[#b84d3a]' }}">
                    {{ $todayVisitsChange >= 0 ? '+' : '' }}{{ $todayVisitsChange }} عن امبارح
                </span>
            </div>

            <div class="grid gap-3 sm:grid-cols-4">
                <div class="rounded-2xl bg-[#fbf9f4] p-3">
                    <p class="text-[11px] font-black text-[#68766d]">النهارده</p>
                    <p class="mt-1 text-2xl font-black text-[#12221d]">{{ $visitStats['today'] }}</p>
                </div>
                <div class="rounded-2xl bg-[#fbf9f4] p-3">
                    <p class="text-[11px] font-black text-[#68766d]">امبارح</p>
                    <p class="mt-1 text-2xl font-black text-[#12221d]">{{ $visitStats['yesterday'] }}</p>
                </div>
                <div class="rounded-2xl bg-[#fbf9f4] p-3">
                    <p class="text-[11px] font-black text-[#68766d]">7 أيام</p>
                    <p class="mt-1 text-2xl font-black text-[#2f7f79]">{{ $visitStats['last_7_days'] }}</p>
                </div>
                <div class="rounded-2xl bg-[#fbf9f4] p-3">
                    <p class="text-[11px] font-black text-[#68766d]">30 يوم</p>
                    <p class="mt-1 text-2xl font-black text-[#d55441]">{{ $visitStats['last_30_days'] }}</p>
                </div>
            </div>

            <div class="mt-5 flex h-32 items-end gap-2">
                @foreach($visitChart as $day)
                    <div class="flex min-w-0 flex-1 flex-col items-center gap-1.5">
                        <div class="flex h-20 w-full items-end rounded-full bg-[#fbf9f4] p-1">
                            <div class="w-full rounded-full bg-[#2f7f79]" style="height: {{ max(8, round(($day['total'] / $maxVisitChart) * 100)) }}%"></div>
                        </div>
                        <span class="text-[10px] font-black text-[#68766d]">{{ $day['label'] }}</span>
                        <span class="text-[11px] font-black text-[#12221d]">{{ $day['total'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        <aside class="space-y-5">
            <section class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_12px_28px_rgba(33,43,37,0.05)]">
                <p class="text-xs font-black text-[#2f7f79]">لينك المنيو</p>
                <input id="menu-link" readonly class="mt-3 w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-3 py-2.5 text-xs font-bold text-[#12221d] outline-none" value="{{ $menuUrl }}">
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <button class="rounded-2xl border border-[#2f7f79] bg-white px-3 py-2.5 text-xs font-black text-[#2f7f79] transition hover:bg-[#eef8f6]" data-copy-target="#menu-link">انسخ</button>
                    <a target="_blank" href="{{ $menuUrl }}" class="inline-flex items-center justify-center rounded-2xl bg-[#12221d] px-3 py-2.5 text-xs font-black text-white transition hover:bg-[#1f3a33]">افتح</a>
                </div>
            </section>

            <section class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_12px_28px_rgba(33,43,37,0.05)]">
                <span class="sr-only">تصميم QR احترافي للطباعة</span>
                <p class="text-xs font-black text-[#d55441]">QR للطباعة</p>
                <input id="dashboard-permanent-qr-link" readonly class="mt-3 w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-3 py-2.5 text-xs font-bold text-[#12221d] outline-none" value="{{ $permanentQrUrl }}">
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <button class="rounded-2xl border border-[#2f7f79] bg-white px-3 py-2.5 text-xs font-black text-[#2f7f79] transition hover:bg-[#eef8f6]" data-copy-target="#dashboard-permanent-qr-link">انسخ</button>
                    <a href="{{ $qrDesignDownloadUrl }}" class="inline-flex items-center justify-center rounded-2xl bg-[#d55441] px-3 py-2.5 text-xs font-black text-white transition hover:bg-[#bd4838]">تحميل</a>
                </div>
                <a href="{{ $qrDesignPreviewUrl }}" target="_blank" class="mt-3 inline-flex text-xs font-black text-[#2f7f79] hover:underline">معاينة التصميم</a>
            </section>
        </aside>
    </div>
</div>
@endsection
