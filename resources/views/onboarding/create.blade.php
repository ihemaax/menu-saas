@extends('layouts.app')

@section('content')
<div class="zz-page max-w-6xl">
    <section class="zz-page-header">
        <h1 class="zz-title">تهيئة حساب المطعم</h1>
        <p class="zz-subtitle mt-1">أكمل البيانات التالية ليصبح حسابك جاهزًا للنشر والإدارة.</p>
    </section>

    <form method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-2">
        @csrf

        <section class="zz-card p-5 md:p-6 space-y-4">
            <h2 class="zz-section-title">معلومات العلامة</h2>
            <div><label class="zz-label">اسم المطعم</label><input id="restaurant-name" name="restaurant_name" class="zz-input" value="{{ old('restaurant_name') }}" required></div>
            <div><label class="zz-label">رقم الهاتف</label><input name="phone" class="zz-input" value="{{ old('phone') }}"></div>
            <div><label class="zz-label">وصف مختصر</label><textarea name="description" rows="4" class="zz-input">{{ old('description') }}</textarea></div>
            <div><label class="zz-label">لوجو المطعم</label><input type="file" name="logo" class="zz-input" accept="image/*"></div>
            <div><label class="zz-label">صورة البانر</label><input type="file" name="banner" class="zz-input" accept="image/*"></div>
        </section>

        <section class="zz-card p-5 md:p-6 space-y-4">
            <h2 class="zz-section-title">إعدادات النشر</h2>
            <div>
                <label class="zz-label">Slug</label>
                <input
                    name="slug"
                    class="zz-input"
                    value="{{ old('slug') }}"
                    required
                    data-slug-input
                    data-slug-source="#restaurant-name"
                    data-slug-status="#slug-status"
                    data-slug-preview="#slug-preview"
                >
                <p class="mt-2 text-xs text-slate-500">مثال: <span id="slug-preview" class="font-semibold">{{ url('/menu/'.(old('slug') ?: 'your-name')) }}</span></p>
                <p id="slug-status" class="mt-1 text-xs text-slate-500">سنفحص التوفر مباشرة أثناء الكتابة.</p>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700"><input class="zz-checkbox" type="checkbox" name="is_public" value="1" checked> إتاحة المنيو لأي زائر عبر الرابط</label>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-600">
                بعد الإنهاء، ستدخل إلى لوحة تحكم جاهزة لإضافة الأقسام والمنتجات وإدارة ثيم المنيو.
            </div>

            <button class="zz-btn-primary w-full">إنهاء الإعداد</button>
        </section>
    </form>
</div>
@endsection
