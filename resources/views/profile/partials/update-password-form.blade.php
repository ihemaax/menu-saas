<section>
    <header>
        <p class="text-xs font-black text-[#d55441]">الأمان</p>
        <h2 class="mt-1 text-2xl font-black text-[#12221d]">غيّر الباسورد</h2>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#68766d]">اختار باسورد قوي ومش مستخدم في مكان تاني.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="mb-2 block text-sm font-black text-[#12221d]">الباسورد الحالي</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="mb-2 block text-sm font-black text-[#12221d]">الباسورد الجديد</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="mb-2 block text-sm font-black text-[#12221d]">اكتب الباسورد تاني</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <button class="rounded-2xl bg-[#12221d] px-5 py-3 text-sm font-black text-white transition hover:bg-[#1f3a33]">حفظ الباسورد</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-[#68766d]">تم التحديث.</p>
            @endif
        </div>
    </form>
</section>
