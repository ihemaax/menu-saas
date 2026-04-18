@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <h1 class="zz-title">إعدادات المطعم والمنيو</h1>
        <p class="zz-subtitle mt-1">تحكم في بيانات العلامة، رابط المنيو العام، الثيم، وحالة النشر.</p>
    </section>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="zz-card p-5 md:p-6">
            <h2 class="zz-section-title">بيانات المطعم</h2>
            <p class="zz-subtitle mt-1">المعلومات الأساسية التي تظهر في واجهة العملاء.</p>

            <form method="POST" action="{{ route('settings.restaurant.update') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                @csrf @method('PUT')
                <div><label class="zz-label">اسم المطعم</label><input class="zz-input" name="name" value="{{ old('name', $restaurant->name) }}" required></div>
                <div><label class="zz-label">رقم الهاتف</label><input class="zz-input" name="phone" value="{{ old('phone', $restaurant->phone) }}"></div>
                <div><label class="zz-label">وصف مختصر</label><textarea class="zz-input" name="description" rows="3">{{ old('description', $restaurant->description) }}</textarea></div>
                <div><label class="zz-label">اللوجو</label><input type="file" class="zz-input" name="logo" accept="image/*"></div>
                <div><label class="zz-label">البانر</label><input type="file" class="zz-input" name="banner" accept="image/*"></div>

                <div class="grid gap-3 sm:grid-cols-2">
                    @if($restaurant->logo_path)
                        <img src="{{ asset('storage/'.$restaurant->logo_path) }}" class="h-20 w-20 rounded-2xl border border-slate-200 object-cover" alt="logo">
                    @endif
                    @if($restaurant->banner_path)
                        <img src="{{ asset('storage/'.$restaurant->banner_path) }}" class="h-20 w-full rounded-2xl border border-slate-200 object-cover" alt="banner">
                    @endif
                </div>

                <button class="zz-btn-primary w-full sm:w-auto">حفظ بيانات المطعم</button>
            </form>
        </section>

        <section class="space-y-6">
            <article class="zz-card p-5 md:p-6">
                <h2 class="zz-section-title">إعدادات المنيو</h2>
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
                        <p class="mt-2 text-xs text-slate-500">الرابط النهائي: <span id="slug-preview" class="font-semibold">{{ url('/menu/'.$restaurant->menuSetting->slug) }}</span></p>
                        <p id="slug-status" class="mt-1 text-xs text-slate-500">أي تعديل يُراجع مباشرة.</p>
                    </div>

                    <div>
                        <label class="zz-label">اختيار الثيم</label>
                        <div class="mt-2 grid gap-3 sm:grid-cols-2">
                            @foreach($menuThemes as $key => $theme)
                                <label class="cursor-pointer rounded-2xl border border-slate-200 p-3 transition hover:border-slate-300 has-[:checked]:border-slate-900 has-[:checked]:bg-slate-50">
                                    <input type="radio" class="sr-only" name="theme" value="{{ $key }}" {{ old('theme', $restaurant->menuSetting->theme ?? 'classy') === $key ? 'checked' : '' }}>
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-slate-800">{{ $theme['label'] }}</p>
                                        <div class="flex items-center gap-1">
                                            @foreach($theme['preview_colors'] as $color)
                                                <span class="h-3 w-3 rounded-full border border-slate-200" style="background-color: {{ $color }}"></span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">{{ $theme['description'] }}</p>
                                </label>
                            @endforeach
                        </div>
                        @error('theme')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700"><input class="zz-checkbox" type="checkbox" name="is_public" value="1" {{ old('is_public', $restaurant->menuSetting->is_public) ? 'checked' : '' }}> المنيو متاح للزوار</label>
                    <button class="zz-btn-primary w-full sm:w-auto">حفظ إعدادات المنيو</button>
                </form>
            </article>

            <article class="zz-card p-5 md:p-6">
                <p class="zz-section-title">رابط المنيو والـ QR</p>
                <input id="settings-menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
                <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2"><button data-copy-target="#settings-menu-link" class="zz-btn-secondary">نسخ</button><a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary">فتح</a></div>
                <img src="{{ route('settings.menu.qr') }}" class="mx-auto mt-4 w-44 rounded-2xl border border-slate-200 bg-white p-2" alt="qr">
            </article>
        </section>
    </div>
</div>
@endsection
