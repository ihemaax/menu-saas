<section class="space-y-5">
    <header>
        <p class="text-xs font-black text-[#b84d3a]">منطقة خطيرة</p>
        <h2 class="mt-1 text-2xl font-black text-[#12221d]">حذف الحساب</h2>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#8b3b2e]">لو حذفت الحساب، البيانات المرتبطة بيه هتتمسح ومش هتعرف ترجعها.</p>
    </header>

    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="rounded-2xl bg-[#b84d3a] px-5 py-3 text-sm font-black text-white transition hover:bg-[#9f3f2e]">حذف الحساب</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-[#12221d]">متأكد إنك عايز تحذف الحساب؟</h2>
            <p class="mt-2 text-sm font-semibold leading-7 text-[#68766d]">اكتب الباسورد للتأكيد النهائي.</p>

            <div class="mt-6">
                <label for="password" class="sr-only">الباسورد</label>
                <input id="password" name="password" type="password" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10 md:w-3/4" placeholder="الباسورد">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="rounded-2xl border border-[#d9dfd2] bg-white px-5 py-3 text-sm font-black text-[#12221d] transition hover:bg-[#fbf9f4]">إلغاء</button>
                <button class="rounded-2xl bg-[#b84d3a] px-5 py-3 text-sm font-black text-white transition hover:bg-[#9f3f2e]">تأكيد الحذف</button>
            </div>
        </form>
    </x-modal>
</section>
