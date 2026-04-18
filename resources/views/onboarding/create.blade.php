@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="zz-card p-6">
        <h1 class="zz-title">نجهّز بروفايل مطعمك</h1>
        <p class="zz-subtitle mt-1">المعلومات دي هي اللي الناس هتشوفها في المنيو.</p>
    </div>

    <form method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-2">
        @csrf
        <section class="zz-card p-6 space-y-4">
            <div><label class="zz-label">اسم المطعم</label><input id="restaurant-name" name="restaurant_name" class="zz-input" value="{{ old('restaurant_name') }}" required></div>
            <div><label class="zz-label">رقم التليفون</label><input name="phone" class="zz-input" value="{{ old('phone') }}"></div>
            <div><label class="zz-label">وصف بسيط</label><textarea name="description" rows="3" class="zz-input">{{ old('description') }}</textarea></div>
            <div><label class="zz-label">لوجو المكان (صورة البروفايل)</label><input type="file" name="logo" class="zz-input" accept="image/*"></div>
            <div><label class="zz-label">صورة الكفر / البانر</label><input type="file" name="banner" class="zz-input" accept="image/*"></div>
        </section>

        <section class="zz-card p-6 space-y-4">
            <div>
                <label class="zz-label">لينك المنيو المختصر (Slug)</label>
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
                <p class="mt-2 text-xs text-slate-500">يعني إيه؟ ده الجزء اللي بيظهر آخر لينك المنيو. مثال: <span id="slug-preview" class="font-semibold">{{ url('/menu/'.(old('slug') ?: 'your-name')) }}</span></p>
                <p id="slug-status" class="mt-1 text-xs text-slate-500">اكتب الاسم وإحنا هنتأكد فورًا لو متاح.</p>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="is_public" value="1" checked> المنيو يكون متاح لأي حد باللينك</label>
            <button class="zz-btn-primary w-full">خلص الإعداد وادخل على اللوحة</button>
        </section>
    </form>
</div>
@endsection
