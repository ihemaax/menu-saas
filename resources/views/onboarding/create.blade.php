@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <p class="text-xs font-black text-[#2f7f79]">أول إعداد</p>
        <h1 class="mt-1 text-3xl font-black text-[#12221d]">يلا نجهز صفحة مكانك</h1>
        <p class="mt-2 max-w-2xl text-sm font-semibold leading-7 text-[#68766d]">اكتب البيانات الأساسية اللي العميل هيشوفها أول ما يفتح المنيو. تقدر تعدل كل ده بعدين من الإعدادات.</p>
    </section>

    <form method="POST" action="{{ route('onboarding.store') }}" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-2">
        @csrf
        <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
            <p class="text-xs font-black text-[#d55441]">بيانات المكان</p>
            <h2 class="mt-1 text-2xl font-black text-[#12221d]">الاسم والصور</h2>

            <div class="mt-5 space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-black text-[#12221d]">اسم المكان</label>
                    <input id="restaurant-name" name="restaurant_name" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" value="{{ old('restaurant_name') }}" required>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-[#12221d]">رقم الموبايل</label>
                    <input name="phone" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" value="{{ old('phone') }}">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-[#12221d]">نبذة بسيطة</label>
                    <textarea name="description" rows="3" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" placeholder="وصف قصير عن المكان أو التخصص">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-[#12221d]">اللوجو</label>
                    <input type="file" name="logo" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] file:ml-4 file:rounded-xl file:border-0 file:bg-[#12221d] file:px-4 file:py-2 file:text-sm file:font-black file:text-white" accept="image/*">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-[#12221d]">صورة الغلاف</label>
                    <input type="file" name="banner" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] file:ml-4 file:rounded-xl file:border-0 file:bg-[#12221d] file:px-4 file:py-2 file:text-sm file:font-black file:text-white" accept="image/*">
                </div>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
            <p class="text-xs font-black text-[#2f7f79]">لينك المنيو</p>
            <h2 class="mt-1 text-2xl font-black text-[#12221d]">اختار اسم لينك سهل</h2>

            <div class="mt-5 space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-black text-[#12221d]">اللينك المختصر</label>
                    <input name="slug" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" value="{{ old('slug') }}" required pattern="[a-z0-9-]+" inputmode="latin" spellcheck="false" autocapitalize="off" title="اكتب slug بالإنجليزي فقط" data-slug-input data-slug-source="#restaurant-name" data-slug-status="#slug-status" data-slug-preview="#slug-preview">
                    <p class="mt-2 text-xs font-bold text-[#68766d]">مثال: <span id="slug-preview" class="text-[#12221d]">{{ url('/menu/'.(old('slug') ?: 'your-name')) }}</span></p>
                    <p id="slug-status" class="mt-1 text-xs font-bold text-[#68766d]">اكتب الاسم وإحنا هنتأكد فوراً إنه متاح.</p>
                </div>

                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-[#dce4d8] bg-[#fbf9f4] p-4 text-sm font-black text-[#12221d]">
                    <input type="checkbox" class="h-4 w-4 rounded border-[#cdd6ca] text-[#2f7f79] focus:ring-[#2f7f79]/30" name="is_public" value="1" checked>
                    خلي المنيو متاح لأي حد معاه اللينك
                </label>

                <div class="rounded-3xl bg-[#12221d] p-5 text-white">
                    <p class="text-sm font-black">بعد الخطوة دي</p>
                    <p class="mt-2 text-sm font-semibold leading-7 text-[#c5d4ca]">هتدخل على اللوحة وتبدأ تضيف الأقسام والأصناف وتحمّل QR للطباعة.</p>
                </div>

                <button class="w-full rounded-2xl bg-[#d55441] px-5 py-4 text-sm font-black text-white transition hover:bg-[#bd4838]">خلص الإعداد وادخل اللوحة</button>
            </div>
        </section>
    </form>
</div>
@endsection
