<section>
    <header>
        <p class="text-xs font-black text-[#2f7f79]">بياناتك</p>
        <h2 class="mt-1 text-2xl font-black text-[#12221d]">الاسم والإيميل</h2>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#68766d]">حدّث بيانات الحساب اللي بتدخل بيها على اللوحة.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="mb-2 block text-sm font-black text-[#12221d]">الاسم</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-black text-[#12221d]">الإيميل</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm font-semibold text-[#68766d]">
                        الإيميل لسه مش متأكد.
                        <button form="send-verification" class="font-black text-[#2f7f79] underline hover:text-[#23625c]">ابعت رسالة تأكيد جديدة</button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-black text-[#23625c]">بعتنالك لينك التفعيل على الإيميل.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <button class="rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white transition hover:bg-[#bd4838]">حفظ البيانات</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-[#68766d]">تم الحفظ.</p>
            @endif
        </div>
    </form>
</section>
