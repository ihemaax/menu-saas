@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-2">
    <section class="zz-card p-6">
        <h2 class="text-xl font-bold">بيانات المطعم</h2>
        <form method="POST" action="{{ route('settings.restaurant.update') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf @method('PUT')
            <div><label class="zz-label">اسم المطعم</label><input class="zz-input" name="name" value="{{ old('name', $restaurant->name) }}" required></div>
            <div><label class="zz-label">التليفون</label><input class="zz-input" name="phone" value="{{ old('phone', $restaurant->phone) }}"></div>
            <div><label class="zz-label">وصف مختصر</label><textarea class="zz-input" name="description" rows="3">{{ old('description', $restaurant->description) }}</textarea></div>
            <div><label class="zz-label">اللوجو (صورة البروفايل)</label><input type="file" class="zz-input" name="logo" accept="image/*"></div>
            <div><label class="zz-label">صورة الكفر / البانر</label><input type="file" class="zz-input" name="banner" accept="image/*"></div>
            <div class="grid gap-3 sm:grid-cols-2">
                @if($restaurant->logo_path)<img src="{{ asset('storage/'.$restaurant->logo_path) }}" class="h-20 w-20 rounded-full object-cover" alt="logo">@endif
                @if($restaurant->banner_path)<img src="{{ asset('storage/'.$restaurant->banner_path) }}" class="h-20 w-full rounded-xl object-cover" alt="banner">@endif
            </div>
            <button class="zz-btn-primary">حفظ</button>
        </form>
    </section>

    <section class="zz-card p-6">
        <h2 class="text-xl font-bold">إعدادات المنيو</h2>
        <form method="POST" action="{{ route('settings.menu.update') }}" class="mt-5 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="zz-label">Slug</label>
                <input
                    name="slug"
                    class="zz-input"
                    value="{{ old('slug', $restaurant->menuSetting->slug) }}"
                    required
                    data-slug-input
                    data-slug-status="#slug-status"
                    data-slug-preview="#slug-preview"
                >
                <p class="mt-2 text-xs text-slate-500">لينكك النهائي: <span id="slug-preview" class="font-semibold">{{ url('/menu/'.$restaurant->menuSetting->slug) }}</span></p>
                <p id="slug-status" class="mt-1 text-xs text-slate-500">أي تعديل بيتراجع مباشرة.</p>
            </div>
            <label class="flex items-center gap-2"><input type="checkbox" name="is_public" value="1" {{ old('is_public', $restaurant->menuSetting->is_public) ? 'checked' : '' }}> المنيو متاح للناس</label>
            <button class="zz-btn-primary">حفظ إعدادات المنيو</button>
        </form>

        <div class="mt-6 space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-sm font-semibold">لينك المنيو</p>
            <input id="settings-menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
            <div class="flex gap-2"><button data-copy-target="#settings-menu-link" class="zz-btn-secondary w-full">نسخ</button><a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary w-full">فتح</a></div>
            <img src="{{ route('settings.menu.qr') }}" class="mx-auto w-44 rounded-lg border border-slate-200 bg-white p-2" alt="qr">
        </div>
    </section>
</div>
@endsection
