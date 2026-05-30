@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-black text-[#2f7f79]">إعدادات المكان</p>
                <h1 class="mt-1 text-3xl font-black text-[#12221d]">ظبط شكل وبيانات المنيو</h1>
                <p class="mt-2 max-w-2xl text-sm font-semibold leading-7 text-[#68766d]">البيانات اللي هنا هي اللي العميل بيشوفها. خليك واضح في الاسم والصورة واللينك.</p>
            </div>
            <a target="_blank" href="{{ $menuUrl }}" class="inline-flex items-center justify-center rounded-2xl bg-[#12221d] px-5 py-3 text-sm font-black text-white transition hover:bg-[#1f3a33]">افتح المنيو</a>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-[1fr_420px]">
        <section class="space-y-6">
            <div class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
                <div class="mb-5">
                    <p class="text-xs font-black text-[#d55441]">بيانات المكان</p>
                    <h2 class="mt-1 text-2xl font-black text-[#12221d]">الاسم والصور اللي بتظهر للعميل</h2>
                </div>

                <form method="POST" action="{{ route('settings.restaurant.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-black text-[#12221d]">اسم المكان</label>
                            <input class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="name" value="{{ old('name', $restaurant->name) }}" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-black text-[#12221d]">رقم الموبايل</label>
                            <input class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="phone" value="{{ old('phone', $restaurant->phone) }}" placeholder="مثال: 0100XXXXXXX">
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-black text-[#12221d]">العنوان</label>
                        <input class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="address" value="{{ old('address', $restaurant->address) }}" placeholder="مثال: 15 شارع البحر">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-black text-[#12221d]">وصف قصير</label>
                        <textarea class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="description" rows="3" placeholder="جملة بسيطة عن المكان">{{ old('description', $restaurant->description) }}</textarea>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-black text-[#12221d]">اللوجو</label>
                            <input type="file" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] file:ml-4 file:rounded-xl file:border-0 file:bg-[#12221d] file:px-4 file:py-2 file:text-sm file:font-black file:text-white" name="logo" accept="image/*">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-black text-[#12221d]">صورة الغلاف</label>
                            <input type="file" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] file:ml-4 file:rounded-xl file:border-0 file:bg-[#12221d] file:px-4 file:py-2 file:text-sm file:font-black file:text-white" name="banner" accept="image/*">
                        </div>
                    </div>

                    @if($restaurant->logo_path || $restaurant->banner_path)
                        <div class="grid gap-3 sm:grid-cols-2">
                            @if($restaurant->logo_path)
                                <img src="{{ asset('storage/'.$restaurant->logo_path) }}" class="h-24 w-24 rounded-3xl object-cover shadow-[0_14px_34px_rgba(33,43,37,0.12)]" alt="logo">
                            @endif
                            @if($restaurant->banner_path)
                                <img src="{{ asset('storage/'.$restaurant->banner_path) }}" class="h-24 w-full rounded-3xl object-cover shadow-[0_14px_34px_rgba(33,43,37,0.12)]" alt="banner">
                            @endif
                        </div>
                    @endif

                    <button class="inline-flex w-full items-center justify-center rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white transition hover:bg-[#bd4838] sm:w-auto">حفظ بيانات المكان</button>
                </form>
            </div>

            <div class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
                <div class="mb-5">
                    <p class="text-xs font-black text-[#2f7f79]">إعدادات المنيو</p>
                    <h2 class="mt-1 text-2xl font-black text-[#12221d]">اللينك والثيم وحالة النشر</h2>
                </div>

                <form method="POST" action="{{ route('settings.menu.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="mb-2 block text-sm font-black text-[#12221d]">اسم لينك المنيو</label>
                        <input name="slug" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" value="{{ old('slug', $restaurant->menuSetting->slug) }}" required pattern="[a-z0-9-]+" inputmode="latin" spellcheck="false" autocapitalize="off" title="اكتب slug بالإنجليزي فقط" data-slug-input data-slug-status="#slug-status" data-slug-preview="#slug-preview">
                        <p class="mt-2 text-xs font-bold text-[#68766d]">الرابط النهائي: <span id="slug-preview" class="text-[#12221d]">{{ url('/menu/'.$restaurant->menuSetting->slug) }}</span></p>
                        <p id="slug-status" class="mt-1 text-xs font-bold text-[#68766d]">أي تعديل هنتأكد منه فوراً.</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-black text-[#12221d]">ثيم المنيو</label>
                        <select name="theme" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" required>
                            <option value="classy" @selected(old('theme', $restaurant->menuSetting->theme ?? 'classy') === 'classy')>Classic</option>
                            <option value="tree" @selected(old('theme', $restaurant->menuSetting->theme ?? 'classy') === 'tree')>Tree Essence</option>
                            <option value="sipchill" @selected(old('theme', $restaurant->menuSetting->theme ?? 'classy') === 'sipchill')>Sipchill</option>
                            <option value="ng" @selected(old('theme', $restaurant->menuSetting->theme ?? 'classy') === 'ng')>NG Theme</option>
                            <option value="paper" @selected(old('theme', $restaurant->menuSetting->theme ?? 'classy') === 'paper')>Paper</option>
                        </select>
                    </div>

                    <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-[#dce4d8] bg-[#fbf9f4] p-4 text-sm font-black text-[#12221d]">
                        <input type="checkbox" class="h-4 w-4 rounded border-[#cdd6ca] text-[#2f7f79] focus:ring-[#2f7f79]/30" name="is_public" value="1" {{ old('is_public', $restaurant->menuSetting->is_public) ? 'checked' : '' }}>
                        المنيو متاح لأي حد معاه اللينك
                    </label>

                    <button class="inline-flex w-full items-center justify-center rounded-2xl bg-[#12221d] px-5 py-3 text-sm font-black text-white transition hover:bg-[#1f3a33] sm:w-auto">حفظ إعدادات المنيو</button>
                </form>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)]">
                <p class="text-xs font-black text-[#2f7f79]">اللينكات</p>
                <h2 class="mt-1 text-xl font-black text-[#12221d]">انسخ وابعت بسرعة</h2>

                <div class="mt-5 space-y-4">
                    <div>
                        <label class="mb-2 block text-xs font-black text-[#68766d]">لينك المنيو الحالي</label>
                        <input id="settings-menu-link" readonly class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-xs font-bold text-[#12221d]" value="{{ $menuUrl }}">
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            <button data-copy-target="#settings-menu-link" class="rounded-2xl border border-[#2f7f79] bg-white px-3 py-2.5 text-xs font-black text-[#2f7f79] transition hover:bg-[#eef8f6]">انسخ</button>
                            <a target="_blank" href="{{ $menuUrl }}" class="inline-flex items-center justify-center rounded-2xl bg-[#12221d] px-3 py-2.5 text-xs font-black text-white">افتح</a>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-[#68766d]">رابط QR الثابت</label>
                        <input id="settings-permanent-qr-link" readonly class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-xs font-bold text-[#12221d]" value="{{ $permanentQrUrl }}">
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            <button data-copy-target="#settings-permanent-qr-link" class="rounded-2xl border border-[#2f7f79] bg-white px-3 py-2.5 text-xs font-black text-[#2f7f79] transition hover:bg-[#eef8f6]">انسخ</button>
                            <a target="_blank" href="{{ $permanentQrUrl }}" class="inline-flex items-center justify-center rounded-2xl bg-[#2f7f79] px-3 py-2.5 text-xs font-black text-white">افتح</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[30px] border border-[#dce4d8] bg-white p-5 text-center shadow-[0_16px_38px_rgba(33,43,37,0.06)]">
                <p class="text-xs font-black text-[#d55441]">QR للطباعة</p>
                <h2 class="mt-1 text-xl font-black text-[#12221d]">جاهز يتحط في المكان</h2>
                <img src="{{ route('settings.menu.qr') }}" class="mx-auto mt-5 w-44 rounded-3xl border border-[#dce4d8] bg-white p-3 shadow-sm" alt="permanent qr">
                <div class="mt-4 grid gap-2 sm:grid-cols-2">
                    <a href="{{ route('settings.menu.qr') }}" download="permanent-menu-qr.svg" class="inline-flex items-center justify-center rounded-2xl border border-[#2f7f79] bg-white px-4 py-3 text-sm font-black text-[#2f7f79] transition hover:bg-[#eef8f6]">QR لوحده</a>
                    <a href="{{ $qrDesignDownloadUrl }}" class="inline-flex items-center justify-center rounded-2xl bg-[#d55441] px-4 py-3 text-sm font-black text-white transition hover:bg-[#bd4838]">تصميم كامل</a>
                </div>
                <a href="{{ $qrDesignPreviewUrl }}" target="_blank" class="mt-3 inline-flex text-xs font-black text-[#2f7f79] hover:underline">عاين التصميم</a>
                <div class="mt-4 overflow-hidden rounded-3xl border border-[#dce4d8] bg-[#fbf9f4]">
                    <iframe src="{{ $qrDesignPreviewUrl }}" title="QR print design preview" class="h-72 w-full" loading="lazy"></iframe>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
