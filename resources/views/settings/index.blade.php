@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-2">
    <section class="zz-card">
        <h2 class="zz-section-title">بيانات المطعم</h2>
        <p class="zz-subtitle mt-1">دي المعلومات اللي بتظهر للعميل في المنيو.</p>

        <form method="POST" action="{{ route('settings.restaurant.update') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf @method('PUT')
            <div><label class="zz-label">اسم المطعم</label><input class="zz-input" name="name" value="{{ old('name', $restaurant->name) }}" required></div>
            <div><label class="zz-label">رقم الموبايل</label><input class="zz-input" name="phone" value="{{ old('phone', $restaurant->phone) }}" placeholder="مثال: 0100XXXXXXX"></div>
            <div><label class="zz-label">عنوان المطعم</label><input class="zz-input" name="address" value="{{ old('address', $restaurant->address) }}" placeholder="مثال: 15 ش البحر، سيدي بشر، الإسكندرية"></div>
            <div><label class="zz-label">وصف مختصر</label><textarea class="zz-input" name="description" rows="3" placeholder="اكتب نبذة بسيطة عن المطعم">{{ old('description', $restaurant->description) }}</textarea></div>
            <div><label class="zz-label">اللوجو</label><input type="file" class="zz-input" name="logo" accept="image/*"></div>
            <div><label class="zz-label">صورة الغلاف</label><input type="file" class="zz-input" name="banner" accept="image/*"></div>
            <div class="grid gap-3 sm:grid-cols-2">
                @if($restaurant->logo_path)<img src="{{ asset('storage/'.$restaurant->logo_path) }}" class="h-20 w-20 rounded-full object-cover" alt="logo">@endif
                @if($restaurant->banner_path)<img src="{{ asset('storage/'.$restaurant->banner_path) }}" class="h-20 w-full rounded-xl object-cover" alt="banner">@endif
            </div>
            <button class="zz-btn-primary">حفظ التعديلات</button>
        </form>
    </section>

    <section class="zz-card">
        <h2 class="zz-section-title">إعدادات المنيو</h2>
        <p class="zz-subtitle mt-1">ظبط الرابط، شكل العرض، وحالة إتاحة المنيو.</p>

        <form method="POST" action="{{ route('settings.menu.update') }}" class="mt-5 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="zz-label">Slug المنيو</label>
                <input name="slug" class="zz-input" value="{{ old('slug', $restaurant->menuSetting->slug) }}" required pattern="[a-z0-9-]+" inputmode="latin" spellcheck="false" autocapitalize="off" title="اكتب الـ slug بالإنجليزي فقط (a-z, 0-9, -)" data-slug-input data-slug-status="#slug-status" data-slug-preview="#slug-preview">
                <p class="mt-2 text-xs text-[#6e695e]">الرابط النهائي: <span id="slug-preview" class="font-semibold">{{ url('/menu/'.$restaurant->menuSetting->slug) }}</span></p>
                <p id="slug-status" class="mt-1 text-xs text-[#6e695e]">أي تعديل بيتراجع فورًا.</p>
            </div>

            <div>
                <label class="zz-label">ثيم المنيو</label>
                <select name="theme" class="zz-input" required>
                    <option value="classy" @selected(old('theme', $restaurant->menuSetting->theme ?? 'classy') === 'classy')>Classic (الأساسي)</option>
                    <option value="tree" @selected(old('theme', $restaurant->menuSetting->theme ?? 'classy') === 'tree')>Tree Essence (جديد)</option>
                </select>
                <p class="mt-2 text-xs text-[#6e695e]">تقدر تبدّل بين الثيم الأساسي والثيم الجديد في أي وقت.</p>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-[#2f3a2f]"><input type="checkbox" class="zz-checkbox" name="is_public" value="1" {{ old('is_public', $restaurant->menuSetting->is_public) ? 'checked' : '' }}> المنيو متاحة لأي حد معاه اللينك</label>
            <button class="zz-btn-primary">حفظ إعدادات المنيو</button>
        </form>

        <div class="mt-6 space-y-4 rounded-2xl border border-[#e3dacb] bg-[#f8f5ef] p-4">
            <div class="space-y-2">
                <p class="text-sm font-semibold">لينك المنيو الحالي</p>
                <input id="settings-menu-link" readonly class="zz-input" value="{{ $menuUrl }}">
                <div class="flex gap-2">
                    <button data-copy-target="#settings-menu-link" class="zz-btn-secondary w-full">نسخ لينك المنيو</button>
                    <a target="_blank" href="{{ $menuUrl }}" class="zz-btn-primary w-full">فتح المنيو</a>
                </div>
            </div>

            <div class="space-y-2 rounded-2xl border border-[#dfd6c6] bg-white p-3">
                <p class="text-sm font-semibold">رابط QR الثابت (Permanent QR Link)</p>
                <input id="settings-permanent-qr-link" readonly class="zz-input" value="{{ $permanentQrUrl }}">
                <div class="flex gap-2">
                    <button data-copy-target="#settings-permanent-qr-link" class="zz-btn-secondary w-full">نسخ رابط QR الثابت</button>
                    <a target="_blank" href="{{ $permanentQrUrl }}" class="zz-btn-primary w-full">فتح الرابط الثابت</a>
                </div>
                <p class="text-xs leading-6 text-[#6e695e]">هذا الرابط ثابت ولا يتغير حتى لو تم تغيير اسم المطعم أو رابط المنيو. استخدم هذا الرابط عند طباعة QR Code للعميل.</p>
            </div>

            <div class="rounded-2xl border border-[#dfd6c6] bg-white p-3 text-center">
                <p class="text-sm font-semibold">QR ثابت جاهز للطباعة</p>
                <img src="{{ route('settings.menu.qr') }}" class="mx-auto mt-3 w-44 rounded-2xl border border-[#dfd6c6] bg-white p-2" alt="permanent qr">
                <a href="{{ route('settings.menu.qr') }}" download="permanent-menu-qr.svg" class="zz-btn-secondary mt-3 w-full">تحميل QR (SVG)</a>
            </div>
        </div>
    </section>
</div>
@endsection
