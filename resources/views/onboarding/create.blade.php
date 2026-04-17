@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl zz-card p-6 md:p-8">
    <h1 class="zz-title">إعداد المطعم لأول مرة</h1>
    <p class="zz-subtitle mt-2">أكمل بيانات نشاطك لإنشاء Tenant معزول ورابط منيو فريد.</p>

    <form method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data" class="mt-6 grid gap-5">
        @csrf
        <div>
            <label class="zz-label">اسم المطعم</label>
            <input name="restaurant_name" class="zz-input" value="{{ old('restaurant_name') }}" required>
        </div>
        <div>
            <label class="zz-label">الهاتف</label>
            <input name="phone" class="zz-input" value="{{ old('phone') }}">
        </div>
        <div>
            <label class="zz-label">وصف مختصر</label>
            <textarea name="description" class="zz-input" rows="3">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="zz-label">Slug المنيو (فريد عالميًا)</label>
            <input name="slug" class="zz-input" value="{{ old('slug') }}" required>
        </div>
        <div>
            <label class="zz-label">شعار المطعم</label>
            <input type="file" name="logo" class="zz-input" accept="image/*">
        </div>
        <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="is_public" value="1" checked class="size-4 rounded border-slate-300">
            المنيو متاح للعامة
        </label>

        <button class="zz-btn-primary">إكمال الإعداد</button>
    </form>
</div>
@endsection
