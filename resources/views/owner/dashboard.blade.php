@extends('layouts.app')

@section('content')
@php
    $stats = [
        'total' => $restaurants->count(),
        'active' => $restaurants->where('subscription_status', 'active')->count(),
        'expired' => $restaurants->where('subscription_status', 'expired')->count(),
        'public_menu' => $restaurants->filter(fn($restaurant) => (bool) $restaurant->menuSetting?->is_public)->count(),
    ];

    $statusMap = [
        'active' => ['label' => 'نشط', 'class' => 'zz-badge-active'],
        'inactive' => ['label' => 'غير نشط', 'class' => 'zz-badge-muted'],
        'suspended' => ['label' => 'موقوف', 'class' => 'zz-badge-danger'],
        'expired' => ['label' => 'منتهي', 'class' => 'zz-badge-muted'],
    ];
@endphp

<div class="space-y-5">
    <section class="zz-card space-y-5">
        <div class="space-y-2">
            <h1 class="zz-title">إدارة المطاعم والاشتراكات</h1>
            <p class="zz-subtitle">تابع حالة كل حساب بسرعة، وعدّل الاشتراك أو افتح رابط المنيو من نفس الشاشة.</p>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <article class="zz-stat-card">
                <p class="zz-stat-label">إجمالي الحسابات</p>
                <p class="zz-stat-value">{{ $stats['total'] }}</p>
            </article>
            <article class="zz-stat-card">
                <p class="zz-stat-label">اشتراكات نشطة</p>
                <p class="zz-stat-value text-[#3e5a20]">{{ $stats['active'] }}</p>
            </article>
            <article class="zz-stat-card">
                <p class="zz-stat-label">اشتراكات منتهية</p>
                <p class="zz-stat-value text-[#8f3d2f]">{{ $stats['expired'] }}</p>
            </article>
            <article class="zz-stat-card">
                <p class="zz-stat-label">منيو متاحة الآن</p>
                <p class="zz-stat-value text-[#2d6a62]">{{ $stats['public_menu'] }}</p>
            </article>
        </div>
    </section>

    @if($restaurants->isEmpty())
        <section class="zz-empty">لسه مفيش مطاعم مضافة. أول ما يتم إنشاء حساب جديد هتلاقيه هنا تلقائيًا.</section>
    @else
        <section class="zz-table-wrap hidden xl:block">
            <div class="overflow-x-auto">
                <table class="zz-table zz-owner-table">
                    <thead>
                    <tr>
                        <th>المطعم / الحساب</th>
                        <th>البيانات</th>
                        <th>الحالة</th>
                        <th>الإحصائيات</th>
                        <th>إجراءات سريعة</th>
                        <th>تحديث الاشتراك</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($restaurants as $restaurant)
                        @php
                            $owner = $restaurant->users->first();
                            $statusData = $statusMap[$restaurant->subscription_status] ?? ['label' => 'غير محدد', 'class' => 'zz-badge-muted'];
                            $menuUrl = $restaurant->menuSetting?->slug ? route('menu.show', $restaurant->menuSetting->slug) : null;
                            $isPublicMenu = (bool) $restaurant->menuSetting?->is_public;
                        @endphp
                        <tr>
                            <td>
                                <div class="space-y-1">
                                    <p class="font-bold text-[#2b3526]">{{ $restaurant->name }}</p>
                                    <p class="text-xs text-[#7a756a]">رقم الحساب: #{{ $restaurant->id }}</p>
                                    @if($restaurant->menuSetting?->slug)
                                        <p class="text-xs text-[#7a756a]">Slug: <span class="font-semibold text-[#2f3a2f]">{{ $restaurant->menuSetting->slug }}</span></p>
                                    @else
                                        <p class="text-xs text-[#a0937f]">Slug غير متاح</p>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="space-y-1 text-[13px] leading-6">
                                    <p><span class="font-semibold text-[#5f695f]">المالك:</span> {{ $owner?->name ?: '-' }}</p>
                                    <p><span class="font-semibold text-[#5f695f]">البريد:</span> {{ $owner?->email ?: '-' }}</p>
                                    <p><span class="font-semibold text-[#5f695f]">الهاتف:</span> {{ $restaurant->phone ?: '-' }}</p>
                                    <p><span class="font-semibold text-[#5f695f]">تاريخ الإنشاء:</span> {{ $restaurant->created_at->format('Y-m-d') }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="space-y-2">
                                    <span class="zz-badge {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                                    <div>
                                        <p class="text-[11px] text-[#7a756a]">بداية: {{ $restaurant->subscription_starts_at?->format('Y-m-d') ?: '-' }}</p>
                                        <p class="text-[11px] text-[#7a756a]">نهاية: {{ $restaurant->subscription_ends_at?->format('Y-m-d') ?: '-' }}</p>
                                    </div>
                                    <span class="zz-badge {{ $isPublicMenu ? 'zz-badge-info' : 'zz-badge-muted' }}">{{ $isPublicMenu ? 'المنيو متاحة' : 'المنيو مخفية' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-2">
                                    <span class="zz-chip">الأقسام: {{ $restaurant->categories_count }}</span>
                                    <span class="zz-chip">المنتجات: {{ $restaurant->products_count }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-2">
                                    @if($menuUrl)
                                        <a href="{{ $menuUrl }}" target="_blank" class="zz-btn-secondary !rounded-xl !px-3 !py-1.5 !text-xs">فتح المنيو</a>
                                        <button type="button" data-copy-link="{{ $menuUrl }}" class="zz-btn-ghost !rounded-xl !px-3 !py-1.5 !text-xs">نسخ الرابط</button>
                                    @else
                                        <span class="text-xs text-[#9b988f]">لا يوجد رابط منيو حاليًا</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('owner.restaurants.subscription.update', $restaurant) }}" method="POST" class="zz-action-grid">
                                    @csrf
                                    @method('PATCH')
                                    <div>
                                        <label class="zz-mini-label">الحالة</label>
                                        <select name="subscription_status" class="zz-input zz-input-compact">
                                            <option value="active" @selected($restaurant->subscription_status === 'active')>نشط</option>
                                            <option value="suspended" @selected($restaurant->subscription_status === 'suspended')>موقوف</option>
                                            <option value="expired" @selected($restaurant->subscription_status === 'expired')>منتهي</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="zz-mini-label">بداية الاشتراك</label>
                                        <input type="date" name="subscription_starts_at" value="{{ optional($restaurant->subscription_starts_at)->format('Y-m-d') }}" class="zz-input zz-input-compact">
                                    </div>
                                    <div>
                                        <label class="zz-mini-label">نهاية الاشتراك</label>
                                        <input type="date" name="subscription_ends_at" value="{{ optional($restaurant->subscription_ends_at)->format('Y-m-d') }}" class="zz-input zz-input-compact">
                                    </div>
                                    <button class="zz-btn-primary zz-action-submit">حفظ التحديث</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="space-y-4 xl:hidden">
            @foreach($restaurants as $restaurant)
                @php
                    $owner = $restaurant->users->first();
                    $statusData = $statusMap[$restaurant->subscription_status] ?? ['label' => 'غير محدد', 'class' => 'zz-badge-muted'];
                    $menuUrl = $restaurant->menuSetting?->slug ? route('menu.show', $restaurant->menuSetting->slug) : null;
                    $isPublicMenu = (bool) $restaurant->menuSetting?->is_public;
                @endphp

                <article class="zz-owner-card">
                    <div class="flex flex-wrap items-start justify-between gap-2 border-b border-[#eee6d8] pb-3">
                        <div>
                            <h2 class="text-base font-bold text-[#253126]">{{ $restaurant->name }}</h2>
                            <p class="text-xs text-[#7a756a]">حساب رقم #{{ $restaurant->id }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="zz-badge {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                            <span class="zz-badge {{ $isPublicMenu ? 'zz-badge-info' : 'zz-badge-muted' }}">{{ $isPublicMenu ? 'المنيو متاحة' : 'المنيو مخفية' }}</span>
                        </div>
                    </div>

                    <div class="grid gap-2 text-sm text-[#2f3a2f] sm:grid-cols-2">
                        <p><span class="font-semibold text-[#5f695f]">المالك:</span> {{ $owner?->name ?: '-' }}</p>
                        <p><span class="font-semibold text-[#5f695f]">البريد:</span> {{ $owner?->email ?: '-' }}</p>
                        <p><span class="font-semibold text-[#5f695f]">الهاتف:</span> {{ $restaurant->phone ?: '-' }}</p>
                        <p><span class="font-semibold text-[#5f695f]">الإنشاء:</span> {{ $restaurant->created_at->format('Y-m-d') }}</p>
                        <p class="sm:col-span-2"><span class="font-semibold text-[#5f695f]">Slug:</span> {{ $restaurant->menuSetting?->slug ?: '-' }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="zz-chip">الأقسام: {{ $restaurant->categories_count }}</span>
                        <span class="zz-chip">المنتجات: {{ $restaurant->products_count }}</span>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if($menuUrl)
                            <a href="{{ $menuUrl }}" target="_blank" class="zz-btn-secondary !rounded-xl !px-3 !py-2 !text-xs">فتح المنيو</a>
                            <button type="button" data-copy-link="{{ $menuUrl }}" class="zz-btn-ghost !rounded-xl !px-3 !py-2 !text-xs">نسخ الرابط</button>
                        @endif
                    </div>

                    <form action="{{ route('owner.restaurants.subscription.update', $restaurant) }}" method="POST" class="grid gap-3 border-t border-[#eee6d8] pt-3 sm:grid-cols-2">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="zz-mini-label">الحالة</label>
                            <select name="subscription_status" class="zz-input zz-input-compact">
                                <option value="active" @selected($restaurant->subscription_status === 'active')>نشط</option>
                                <option value="suspended" @selected($restaurant->subscription_status === 'suspended')>موقوف</option>
                                <option value="expired" @selected($restaurant->subscription_status === 'expired')>منتهي</option>
                            </select>
                        </div>
                        <div>
                            <label class="zz-mini-label">بداية الاشتراك</label>
                            <input type="date" name="subscription_starts_at" value="{{ optional($restaurant->subscription_starts_at)->format('Y-m-d') }}" class="zz-input zz-input-compact">
                        </div>
                        <div>
                            <label class="zz-mini-label">نهاية الاشتراك</label>
                            <input type="date" name="subscription_ends_at" value="{{ optional($restaurant->subscription_ends_at)->format('Y-m-d') }}" class="zz-input zz-input-compact">
                        </div>
                        <button class="zz-btn-primary sm:self-end">حفظ التحديث</button>
                    </form>
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
            trigger.textContent = 'اتنسخ الرابط';
            setTimeout(() => {
                trigger.textContent = originalText;
            }, 1400);
        });
    });
</script>
@endsection
