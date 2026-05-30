@extends('layouts.app')

@section('content')
@php
    $stats = [
        'total' => $restaurants->count(),
        'active' => $restaurants->filter(fn($restaurant) => $restaurant->effectiveSubscriptionStatus() === 'active')->count(),
        'expired' => $restaurants->filter(fn($restaurant) => $restaurant->effectiveSubscriptionStatus() === 'expired')->count(),
        'public_menu' => $restaurants->filter(fn($restaurant) => (bool) $restaurant->menuSetting?->is_public)->count(),
    ];

    $statusMap = [
        'active' => ['label' => 'شغال', 'class' => 'bg-[#edf9f5] text-[#23625c]'],
        'inactive' => ['label' => 'مش شغال', 'class' => 'bg-[#f4f0e7] text-[#68766d]'],
        'suspended' => ['label' => 'موقوف', 'class' => 'bg-[#fff0ed] text-[#b84d3a]'],
        'expired' => ['label' => 'منتهي', 'class' => 'bg-[#f4f0e7] text-[#68766d]'],
    ];
@endphp

<div class="space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <p class="text-xs font-black text-[#2f7f79]">لوحة المالك</p>
        <h1 class="mt-1 text-3xl font-black text-[#12221d]">الحسابات والاشتراكات</h1>
        <p class="mt-2 max-w-2xl text-sm font-semibold leading-7 text-[#68766d]">تابع كل مكان، افتح المنيو بتاعه، وعدّل حالة الاشتراك من نفس الصفحة.</p>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_14px_34px_rgba(33,43,37,0.06)]">
            <p class="text-xs font-black text-[#68766d]">كل الحسابات</p>
            <p class="mt-3 text-4xl font-black text-[#12221d]">{{ $stats['total'] }}</p>
        </article>
        <article class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_14px_34px_rgba(33,43,37,0.06)]">
            <p class="text-xs font-black text-[#68766d]">اشتراكات شغالة</p>
            <p class="mt-3 text-4xl font-black text-[#23625c]">{{ $stats['active'] }}</p>
        </article>
        <article class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_14px_34px_rgba(33,43,37,0.06)]">
            <p class="text-xs font-black text-[#68766d]">اشتراكات منتهية</p>
            <p class="mt-3 text-4xl font-black text-[#b84d3a]">{{ $stats['expired'] }}</p>
        </article>
        <article class="rounded-[24px] border border-[#dce4d8] bg-white p-5 shadow-[0_14px_34px_rgba(33,43,37,0.06)]">
            <p class="text-xs font-black text-[#68766d]">منيو منشورة</p>
            <p class="mt-3 text-4xl font-black text-[#2f7f79]">{{ $stats['public_menu'] }}</p>
        </article>
    </section>

    @if($restaurants->isEmpty())
        <section class="rounded-[28px] border border-dashed border-[#d55441]/45 bg-[#fff0ed] p-8 text-center">
            <h2 class="text-2xl font-black text-[#12221d]">لسه مفيش حسابات</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm font-bold leading-7 text-[#8b3b2e]">أول ما حد يعمل حساب ويجهز مكانه، هيظهر هنا تلقائياً.</p>
        </section>
    @else
        <section class="grid gap-4">
            @foreach($restaurants as $restaurant)
                @php
                    $owner = $restaurant->users->first();
                    $statusData = $statusMap[$restaurant->effectiveSubscriptionStatus()] ?? ['label' => 'مش محدد', 'class' => 'bg-[#f4f0e7] text-[#68766d]'];
                    $menuUrl = $restaurant->menuSetting?->slug ? route('menu.show', $restaurant->menuSetting->slug) : null;
                    $isPublicMenu = (bool) $restaurant->menuSetting?->is_public;
                @endphp

                <article class="rounded-[28px] border border-[#dce4d8] bg-white p-5 shadow-[0_14px_34px_rgba(33,43,37,0.06)]">
                    <div class="grid gap-5 xl:grid-cols-[1fr_360px]">
                        <div>
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <h2 class="text-2xl font-black text-[#12221d]">{{ $restaurant->name }}</h2>
                                    <p class="mt-1 text-sm font-bold text-[#68766d]">حساب #{{ $restaurant->id }} · {{ $owner?->name ?: 'بدون مالك' }}</p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full px-3 py-1 text-[11px] font-black {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                                    <span class="rounded-full px-3 py-1 text-[11px] font-black {{ $isPublicMenu ? 'bg-[#edf9f5] text-[#23625c]' : 'bg-[#f4f0e7] text-[#68766d]' }}">{{ $isPublicMenu ? 'المنيو منشورة' : 'المنيو مخفية' }}</span>
                                </div>
                            </div>

                            <div class="mt-5 grid gap-3 text-sm font-bold text-[#68766d] md:grid-cols-2">
                                <p><span class="text-[#12221d]">الإيميل:</span> {{ $owner?->email ?: '-' }}</p>
                                <p><span class="text-[#12221d]">الموبايل:</span> {{ $restaurant->phone ?: '-' }}</p>
                                <p><span class="text-[#12221d]">تاريخ الإنشاء:</span> {{ $restaurant->created_at->format('Y-m-d') }}</p>
                                <p><span class="text-[#12221d]">Slug:</span> {{ $restaurant->menuSetting?->slug ?: '-' }}</p>
                            </div>

                            <div class="mt-5 flex flex-wrap gap-2">
                                <span class="rounded-full bg-[#eef8f6] px-3 py-1 text-xs font-black text-[#2f7f79]">الأقسام: {{ $restaurant->categories_count }}</span>
                                <span class="rounded-full bg-[#fff3df] px-3 py-1 text-xs font-black text-[#94611c]">الأصناف: {{ $restaurant->products_count }}</span>
                            </div>

                            <div class="mt-5 flex flex-wrap gap-2">
                                @if($menuUrl)
                                    <a href="{{ $menuUrl }}" target="_blank" class="inline-flex items-center justify-center rounded-2xl bg-[#12221d] px-4 py-2.5 text-xs font-black text-white transition hover:bg-[#1f3a33]">افتح المنيو</a>
                                    <button type="button" data-copy-link="{{ $menuUrl }}" class="inline-flex items-center justify-center rounded-2xl border border-[#2f7f79] bg-white px-4 py-2.5 text-xs font-black text-[#2f7f79] transition hover:bg-[#eef8f6]">انسخ الرابط</button>
                                @else
                                    <span class="text-xs font-bold text-[#9ba49a]">مفيش رابط منيو حالياً</span>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('owner.restaurants.subscription.update', $restaurant) }}" method="POST" class="rounded-3xl border border-[#dce4d8] bg-[#fbf9f4] p-4">
                            @csrf
                            @method('PATCH')
                            <p class="mb-4 text-sm font-black text-[#12221d]">تحديث الاشتراك</p>
                            <div class="space-y-3">
                                <div>
                                    <label class="mb-1 block text-xs font-black text-[#68766d]">الحالة</label>
                                    <select name="subscription_status" class="w-full rounded-2xl border border-[#d9dfd2] bg-white px-3 py-2.5 text-xs font-bold text-[#12221d]">
                                        <option value="active" @selected($restaurant->subscription_status === 'active')>شغال</option>
                                        <option value="suspended" @selected($restaurant->subscription_status === 'suspended')>موقوف</option>
                                        <option value="expired" @selected($restaurant->subscription_status === 'expired')>منتهي</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1 block text-xs font-black text-[#68766d]">بداية الاشتراك</label>
                                    <input type="date" name="subscription_starts_at" value="{{ optional($restaurant->subscription_starts_at)->format('Y-m-d') }}" class="w-full rounded-2xl border border-[#d9dfd2] bg-white px-3 py-2.5 text-xs font-bold text-[#12221d]">
                                </div>
                                <div>
                                    <label class="mb-1 block text-xs font-black text-[#68766d]">نهاية الاشتراك</label>
                                    <input type="date" name="subscription_ends_at" value="{{ optional($restaurant->subscription_ends_at)->format('Y-m-d') }}" class="w-full rounded-2xl border border-[#d9dfd2] bg-white px-3 py-2.5 text-xs font-bold text-[#12221d]">
                                </div>
                                <button class="w-full rounded-2xl bg-[#d55441] px-4 py-3 text-sm font-black text-white transition hover:bg-[#bd4838]">حفظ التحديث</button>
                            </div>
                        </form>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
</div>

<script>
    document.addEventListener('click', function (event) {
        const trigger = event.target.closest('[data-copy-link]');

        if (!trigger) {
            return;
        }

        const link = trigger.getAttribute('data-copy-link');

        if (!link || !navigator.clipboard) {
            return;
        }

        navigator.clipboard.writeText(link).then(() => {
            const originalText = trigger.textContent;
            trigger.textContent = 'اتنسخ';
            setTimeout(() => {
                trigger.textContent = originalText;
            }, 1400);
        });
    });
</script>
@endsection
