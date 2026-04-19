@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="zz-card">
        <h1 class="zz-title">يلا نجهز صفحة مطعمك</h1>
        <p class="zz-subtitle mt-1">المعلومات دي هتبقى الأساس اللي العميل بيشوفه أول ما يفتح المنيو.</p>
    </div>

    <form method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-2">
        @csrf
        <section class="zz-card space-y-4">
            <div><label class="zz-label">اسم المطعم</label><input id="restaurant-name" name="restaurant_name" class="zz-input" value="{{ old('restaurant_name') }}" required></div>
            <div><label class="zz-label">رقم الموبايل</label><input name="phone" class="zz-input" value="{{ old('phone') }}"></div>
            <div><label class="zz-label">نبذة بسيطة</label><textarea name="description" rows="3" class="zz-input" placeholder="وصف قصير عن المكان أو التخصص">{{ old('description') }}</textarea></div>
            <div><label class="zz-label">اللوجو</label><input type="file" name="logo" class="zz-input" accept="image/*"></div>
            <div><label class="zz-label">صورة الغلاف</label><input type="file" name="banner" class="zz-input" accept="image/*"></div>
        </section>

        <section class="zz-card space-y-4">
            <div>
                <label class="zz-label">لينك المنيو المختصر</label>
                <input name="slug" class="zz-input" value="{{ old('slug') }}" required data-slug-input data-slug-source="#restaurant-name" data-slug-status="#slug-status" data-slug-preview="#slug-preview">
                <p class="mt-2 text-xs text-[#6e695e]">ده الجزء الأخير في رابط المنيو. مثال: <span id="slug-preview" class="font-semibold">{{ url('/menu/'.(old('slug') ?: 'your-name')) }}</span></p>
                <p id="slug-status" class="mt-1 text-xs text-[#6e695e]">اكتب الاسم وإحنا هنتأكد فورًا إنه متاح.</p>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-[#2f3a2f]"><input type="checkbox" class="zz-checkbox" name="is_public" value="1" checked> خلّي المنيو متاحة لأي حد معاه اللينك</label>
            <button class="zz-btn-primary w-full">خلص الإعداد وادخل على اللوحة</button>
        </section>
    </form>
</div>
@endsection
