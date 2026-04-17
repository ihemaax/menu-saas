@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-2">
    <section class="zz-card p-6">
        <h2 class="text-xl font-bold">إعدادات المطعم</h2>
        <form method="POST" action="{{ route('settings.restaurant.update') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf @method('PUT')
            <div><label class="zz-label">اسم المطعم</label><input class="zz-input" name="name" value="{{ old('name', $restaurant->name) }}" required></div>
            <div><label class="zz-label">الهاتف</label><input class="zz-input" name="phone" value="{{ old('phone', $restaurant->phone) }}"></div>
            <div><label class="zz-label">الوصف</label><textarea class="zz-input" name="description" rows="3">{{ old('description', $restaurant->description) }}</textarea></div>
            <div><label class="zz-label">الشعار</label><input type="file" class="zz-input" name="logo" accept="image/*"></div>
            @if($restaurant->logo_path)
                <img src="{{ asset('storage/'.$restaurant->logo_path) }}" class="h-20 w-20 rounded-xl object-cover" alt="logo">
            @endif
            <button class="zz-btn-primary">حفظ بيانات المطعم</button>
        </form>
    </section>

    <section class="zz-card p-6">
        <h2 class="text-xl font-bold">إعدادات المنيو</h2>
        <form method="POST" action="{{ route('settings.menu.update') }}" class="mt-5 space-y-4">
            @csrf @method('PUT')
            <div><label class="zz-label">Slug</label><input class="zz-input" name="slug" value="{{ old('slug', $restaurant->menuSetting->slug) }}" required></div>
            <label class="flex items-center gap-2"><input type="checkbox" name="is_public" value="1" {{ old('is_public', $restaurant->menuSetting->is_public) ? 'checked' : '' }}> المنيو عام</label>
            <button class="zz-btn-primary">تحديث إعدادات المنيو</button>
        </form>

        <div class="mt-6 space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-sm font-semibold">رابط المنيو</p>
            <input id="settings-menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
            <div class="flex gap-2">
                <button data-copy-target="#settings-menu-link" class="zz-btn-secondary w-full">نسخ الرابط</button>
                <a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary w-full">فتح المنيو</a>
            </div>
            <img src="{{ route('settings.menu.qr') }}" class="mx-auto w-52 rounded-lg border border-slate-200 bg-white p-2" alt="qr">
            <a href="{{ route('settings.menu.qr') }}" download="menu-qr.svg" class="zz-btn-secondary w-full">تحميل QR (SVG)</a>
        </div>
    </section>
</div>
@endsection
