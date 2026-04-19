<section class="space-y-6">
    <header>
        <h2 class="zz-section-title">حذف الحساب</h2>
        <p class="mt-1 text-sm text-[#666157]">لو حذفت الحساب، كل البيانات المرتبطة بيه هتتمسح نهائي ومش هتقدر ترجعها.</p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">حذف الحساب</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-[#2b3526]">متأكد إنك عايز تحذف الحساب؟</h2>
            <p class="mt-1 text-sm text-[#666157]">اكتب كلمة السر للتأكيد النهائي.</p>

            <div class="mt-6">
                <x-input-label for="password" value="كلمة السر" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="w-full md:w-3/4" placeholder="كلمة السر" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">إلغاء</x-secondary-button>
                <x-danger-button>تأكيد الحذف</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
