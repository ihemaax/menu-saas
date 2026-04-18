@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="zz-card p-6">
        <h1 class="zz-title">لوحة المالك الرئيسية</h1>
        <p class="zz-subtitle mt-1">إدارة كل المطاعم والاشتراكات من مكان واحد.</p>
    </section>

    <section class="zz-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-right font-bold">المطعم / الحساب</th>
                    <th class="px-4 py-3 text-right font-bold">المالك</th>
                    <th class="px-4 py-3 text-right font-bold">البريد</th>
                    <th class="px-4 py-3 text-right font-bold">الهاتف</th>
                    <th class="px-4 py-3 text-right font-bold">تاريخ الإنشاء</th>
                    <th class="px-4 py-3 text-right font-bold">الحالة</th>
                    <th class="px-4 py-3 text-right font-bold">المنيو</th>
                    <th class="px-4 py-3 text-right font-bold">Slug</th>
                    <th class="px-4 py-3 text-right font-bold">الأقسام</th>
                    <th class="px-4 py-3 text-right font-bold">المنتجات</th>
                    <th class="px-4 py-3 text-right font-bold">الفروع</th>
                    <th class="px-4 py-3 text-right font-bold">التحكم</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                @foreach($restaurants as $restaurant)
                    @php
                        $owner = $restaurant->users->first();
                        $statusMap = [
                            'active' => ['label' => 'نشط', 'class' => 'bg-emerald-100 text-emerald-700'],
                            'suspended' => ['label' => 'موقوف', 'class' => 'bg-rose-100 text-rose-700'],
                            'expired' => ['label' => 'منتهي', 'class' => 'bg-amber-100 text-amber-700'],
                        ];
                        $statusData = $statusMap[$restaurant->subscription_status] ?? ['label' => 'غير محدد', 'class' => 'bg-slate-100 text-slate-700'];
                        $statusLabel = $statusData['label'];
                        $statusClass = $statusData['class'];
                    @endphp
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900">{{ $restaurant->name }}</p>
                            <p class="text-xs text-slate-500">#{{ $restaurant->id }}</p>
                        </td>
                        <td class="px-4 py-3">{{ $owner?->name ?: '-' }}</td>
                        <td class="px-4 py-3">{{ $owner?->email ?: '-' }}</td>
                        <td class="px-4 py-3">{{ $restaurant->phone ?: '-' }}</td>
                        <td class="px-4 py-3">{{ $restaurant->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-bold {{ $statusClass }}">{{ $statusLabel }}</span>
                            <p class="mt-1 text-[11px] text-slate-500">{{ $restaurant->subscription_starts_at?->format('Y-m-d') ?: '-' }} / {{ $restaurant->subscription_ends_at?->format('Y-m-d') ?: '-' }}</p>
                        </td>
                        <td class="px-4 py-3">{{ $restaurant->menuSetting?->is_public ? 'مفعل' : 'مخفي' }}</td>
                        <td class="px-4 py-3">
                            @if($restaurant->menuSetting?->slug)
                                <a class="text-xs text-blue-700 underline" href="{{ route('menu.show', $restaurant->menuSetting->slug) }}" target="_blank">{{ $restaurant->menuSetting->slug }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $restaurant->categories_count }}</td>
                        <td class="px-4 py-3">{{ $restaurant->products_count }}</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('owner.restaurants.subscription.update', $restaurant) }}" method="POST" class="space-y-2">
                                @csrf
                                @method('PATCH')
                                <select name="subscription_status" class="zz-input h-9 py-1 text-xs">
                                    <option value="active" @selected($restaurant->subscription_status === 'active')>نشط</option>
                                    <option value="suspended" @selected($restaurant->subscription_status === 'suspended')>موقوف</option>
                                    <option value="expired" @selected($restaurant->subscription_status === 'expired')>منتهي</option>
                                </select>
                                <input type="date" name="subscription_starts_at" value="{{ optional($restaurant->subscription_starts_at)->format('Y-m-d') }}" class="zz-input h-9 py-1 text-xs">
                                <input type="date" name="subscription_ends_at" value="{{ optional($restaurant->subscription_ends_at)->format('Y-m-d') }}" class="zz-input h-9 py-1 text-xs">
                                <button class="zz-btn-primary w-full py-1.5 text-xs">تحديث</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
