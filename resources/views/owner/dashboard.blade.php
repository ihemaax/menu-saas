@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="zz-title">لوحة مالك المنصة</h1>
                <p class="zz-subtitle mt-1">إدارة الاشتراكات، المطاعم، وحالة النشر من مركز تحكم موحد.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-500">
                إجمالي النتائج المعروضة: {{ $restaurants->count() }}
            </div>
        </div>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
            <article class="zz-card-soft p-4"><p class="text-xs text-slate-500">إجمالي المطاعم</p><p class="mt-2 text-2xl font-black">{{ $stats['total_restaurants'] }}</p></article>
            <article class="zz-card-soft p-4"><p class="text-xs text-slate-500">نشط</p><p class="mt-2 text-2xl font-black text-emerald-700">{{ $stats['active_restaurants'] }}</p></article>
            <article class="zz-card-soft p-4"><p class="text-xs text-slate-500">موقوف</p><p class="mt-2 text-2xl font-black text-rose-700">{{ $stats['suspended_restaurants'] }}</p></article>
            <article class="zz-card-soft p-4"><p class="text-xs text-slate-500">منتهي</p><p class="mt-2 text-2xl font-black text-amber-700">{{ $stats['expired_restaurants'] }}</p></article>
            <article class="zz-card-soft p-4"><p class="text-xs text-slate-500">جديد هذا الشهر</p><p class="mt-2 text-2xl font-black">{{ $stats['new_this_month'] }}</p></article>
        </div>
    </section>

    <section class="zz-card p-5 md:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="zz-section-title">إدارة الحسابات</h2>
                <p class="zz-subtitle mt-1">فلترة سريعة للوصول للمطعم المطلوب وتحديث الاشتراك مباشرة.</p>
            </div>

            <form method="GET" class="grid w-full gap-2 sm:grid-cols-2 lg:w-auto lg:grid-cols-[260px_170px_auto]">
                <input type="search" name="q" value="{{ $filters['q'] }}" placeholder="ابحث باسم مطعم / مالك / بريد" class="zz-input mt-0">
                <select name="status" class="zz-input mt-0">
                    <option value="">كل الحالات</option>
                    <option value="active" @selected($filters['status'] === 'active')>نشط</option>
                    <option value="suspended" @selected($filters['status'] === 'suspended')>موقوف</option>
                    <option value="expired" @selected($filters['status'] === 'expired')>منتهي</option>
                </select>
                <div class="flex gap-2">
                    <button class="zz-btn-primary w-full">تطبيق</button>
                    <a href="{{ route('owner.dashboard') }}" class="zz-btn-secondary w-full">إعادة</a>
                </div>
            </form>
        </div>

        @if($restaurants->isEmpty())
            <div class="zz-empty mt-6">لا توجد نتائج مطابقة للفلاتر الحالية.</div>
        @else
            <div class="mt-5 space-y-4 lg:hidden">
                @foreach($restaurants as $restaurant)
                    @php
                        $owner = $restaurant->users->first();
                        $statusMap = [
                            'active' => ['label' => 'نشط', 'class' => 'bg-emerald-100 text-emerald-700'],
                            'suspended' => ['label' => 'موقوف', 'class' => 'bg-rose-100 text-rose-700'],
                            'expired' => ['label' => 'منتهي', 'class' => 'bg-amber-100 text-amber-700'],
                        ];
                        $statusData = $statusMap[$restaurant->subscription_status] ?? ['label' => 'غير محدد', 'class' => 'bg-slate-100 text-slate-700'];
                    @endphp
                    <article class="rounded-2xl border border-slate-200 bg-white p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $restaurant->name }}</h3>
                                <p class="text-xs text-slate-500">#{{ $restaurant->id }} • {{ $restaurant->created_at->format('Y-m-d') }}</p>
                            </div>
                            <span class="zz-badge {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                        </div>

                        <dl class="mt-3 grid gap-2 text-xs text-slate-600 sm:grid-cols-2">
                            <div><dt class="font-semibold text-slate-500">المالك</dt><dd>{{ $owner?->name ?: '-' }}</dd></div>
                            <div><dt class="font-semibold text-slate-500">البريد</dt><dd class="break-all">{{ $owner?->email ?: '-' }}</dd></div>
                            <div><dt class="font-semibold text-slate-500">الهاتف</dt><dd>{{ $restaurant->phone ?: '-' }}</dd></div>
                            <div><dt class="font-semibold text-slate-500">المنيو</dt><dd>{{ $restaurant->menuSetting?->is_public ? 'مفعل' : 'مخفي' }}</dd></div>
                            <div><dt class="font-semibold text-slate-500">الأقسام/المنتجات</dt><dd>{{ $restaurant->categories_count }} / {{ $restaurant->products_count }}</dd></div>
                            <div><dt class="font-semibold text-slate-500">الفترة</dt><dd>{{ $restaurant->subscription_starts_at?->format('Y-m-d') ?: '-' }} - {{ $restaurant->subscription_ends_at?->format('Y-m-d') ?: '-' }}</dd></div>
                        </dl>

                        <div class="mt-3">
                            @if($restaurant->menuSetting?->slug)
                                <a class="text-xs font-semibold text-blue-700 underline" href="{{ route('menu.show', $restaurant->menuSetting->slug) }}" target="_blank">{{ $restaurant->menuSetting->slug }}</a>
                            @endif
                        </div>

                        <form action="{{ route('owner.restaurants.subscription.update', $restaurant) }}" method="POST" class="mt-4 grid gap-2 sm:grid-cols-2">
                            @csrf
                            @method('PATCH')
                            <select name="subscription_status" class="zz-input mt-0 h-10 py-2 text-xs">
                                <option value="active" @selected($restaurant->subscription_status === 'active')>نشط</option>
                                <option value="suspended" @selected($restaurant->subscription_status === 'suspended')>موقوف</option>
                                <option value="expired" @selected($restaurant->subscription_status === 'expired')>منتهي</option>
                            </select>
                            <button class="zz-btn-primary h-10">تحديث الحالة</button>
                            <input type="date" name="subscription_starts_at" value="{{ optional($restaurant->subscription_starts_at)->format('Y-m-d') }}" class="zz-input mt-0 h-10 py-2 text-xs">
                            <input type="date" name="subscription_ends_at" value="{{ optional($restaurant->subscription_ends_at)->format('Y-m-d') }}" class="zz-input mt-0 h-10 py-2 text-xs">
                        </form>
                    </article>
                @endforeach
            </div>

            <div class="mt-5 hidden overflow-hidden rounded-2xl border border-slate-200 lg:block">
                <div class="overflow-x-auto">
                    <table class="zz-table divide-y divide-slate-200 bg-white">
                        <thead class="bg-slate-50">
                        <tr>
                            <th class="zz-th">المطعم</th>
                            <th class="zz-th">المالك</th>
                            <th class="zz-th">الحالة</th>
                            <th class="zz-th">المنيو</th>
                            <th class="zz-th">Slug</th>
                            <th class="zz-th">أقسام/منتجات</th>
                            <th class="zz-th">تعديل الاشتراك</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                        @foreach($restaurants as $restaurant)
                            @php
                                $owner = $restaurant->users->first();
                                $statusMap = [
                                    'active' => ['label' => 'نشط', 'class' => 'bg-emerald-100 text-emerald-700'],
                                    'suspended' => ['label' => 'موقوف', 'class' => 'bg-rose-100 text-rose-700'],
                                    'expired' => ['label' => 'منتهي', 'class' => 'bg-amber-100 text-amber-700'],
                                ];
                                $statusData = $statusMap[$restaurant->subscription_status] ?? ['label' => 'غير محدد', 'class' => 'bg-slate-100 text-slate-700'];
                            @endphp
                            <tr>
                                <td class="zz-td">
                                    <p class="font-bold text-slate-900">{{ $restaurant->name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">#{{ $restaurant->id }} • {{ $restaurant->phone ?: '-' }}</p>
                                </td>
                                <td class="zz-td">
                                    <p class="font-semibold text-slate-800">{{ $owner?->name ?: '-' }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $owner?->email ?: '-' }}</p>
                                </td>
                                <td class="zz-td">
                                    <span class="zz-badge {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                                    <p class="mt-2 text-xs text-slate-500">{{ $restaurant->subscription_starts_at?->format('Y-m-d') ?: '-' }} / {{ $restaurant->subscription_ends_at?->format('Y-m-d') ?: '-' }}</p>
                                </td>
                                <td class="zz-td">{{ $restaurant->menuSetting?->is_public ? 'مفعل' : 'مخفي' }}</td>
                                <td class="zz-td">
                                    @if($restaurant->menuSetting?->slug)
                                        <a class="text-xs font-semibold text-blue-700 underline" href="{{ route('menu.show', $restaurant->menuSetting->slug) }}" target="_blank">{{ $restaurant->menuSetting->slug }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="zz-td">{{ $restaurant->categories_count }} / {{ $restaurant->products_count }}</td>
                                <td class="zz-td">
                                    <form action="{{ route('owner.restaurants.subscription.update', $restaurant) }}" method="POST" class="grid gap-2 xl:grid-cols-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="subscription_status" class="zz-input mt-0 h-9 py-1.5 text-xs">
                                            <option value="active" @selected($restaurant->subscription_status === 'active')>نشط</option>
                                            <option value="suspended" @selected($restaurant->subscription_status === 'suspended')>موقوف</option>
                                            <option value="expired" @selected($restaurant->subscription_status === 'expired')>منتهي</option>
                                        </select>
                                        <button class="zz-btn-primary h-9 text-xs">تحديث</button>
                                        <input type="date" name="subscription_starts_at" value="{{ optional($restaurant->subscription_starts_at)->format('Y-m-d') }}" class="zz-input mt-0 h-9 py-1.5 text-xs">
                                        <input type="date" name="subscription_ends_at" value="{{ optional($restaurant->subscription_ends_at)->format('Y-m-d') }}" class="zz-input mt-0 h-9 py-1.5 text-xs">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </section>
</div>
@endsection
