@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="zz-card">
        <h1 class="zz-title">لوحة المالك</h1>
        <p class="zz-subtitle mt-1">متابعة كل المطاعم، حالة الاشتراك، وروابط المنيو من شاشة واحدة.</p>
    </section>

    <section class="zz-table-wrap">
        <div class="overflow-x-auto">
            <table class="zz-table">
                <thead>
                <tr>
                    <th>المطعم / الحساب</th>
                    <th>المالك</th>
                    <th>البريد</th>
                    <th>الهاتف</th>
                    <th>تاريخ الإنشاء</th>
                    <th>الاشتراك</th>
                    <th>المنيو</th>
                    <th>Slug</th>
                    <th>الأقسام</th>
                    <th>المنتجات</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-[#eee6d8] bg-white">
                @foreach($restaurants as $restaurant)
                    @php
                        $owner = $restaurant->users->first();
                        $statusMap = [
                            'active' => ['label' => 'نشط', 'class' => 'zz-badge-active'],
                            'suspended' => ['label' => 'موقوف', 'class' => 'zz-badge-danger'],
                            'expired' => ['label' => 'منتهي', 'class' => 'zz-badge-muted'],
                        ];
                        $statusData = $statusMap[$restaurant->subscription_status] ?? ['label' => 'غير محدد', 'class' => 'zz-badge-muted'];
                    @endphp
                    <tr>
                        <td>
                            <p class="font-bold text-[#2b3526]">{{ $restaurant->name }}</p>
                            <p class="text-xs text-[#7a756a]">#{{ $restaurant->id }}</p>
                        </td>
                        <td>{{ $owner?->name ?: '-' }}</td>
                        <td>{{ $owner?->email ?: '-' }}</td>
                        <td>{{ $restaurant->phone ?: '-' }}</td>
                        <td>{{ $restaurant->created_at->format('Y-m-d') }}</td>
                        <td>
                            <span class="zz-badge {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                            <p class="mt-1 text-[11px] text-[#7a756a]">{{ $restaurant->subscription_starts_at?->format('Y-m-d') ?: '-' }} / {{ $restaurant->subscription_ends_at?->format('Y-m-d') ?: '-' }}</p>
                        </td>
                        <td>{{ $restaurant->menuSetting?->is_public ? 'متاحة' : 'مخفية' }}</td>
                        <td>
                            @if($restaurant->menuSetting?->slug)
                                <a class="text-xs text-[#6f7f43] underline" href="{{ route('menu.show', $restaurant->menuSetting->slug) }}" target="_blank">{{ $restaurant->menuSetting->slug }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $restaurant->categories_count }}</td>
                        <td>{{ $restaurant->products_count }}</td>
                        <td>
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
                                <button class="zz-btn-primary w-full py-1.5 text-xs">تحديث الحالة</button>
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
