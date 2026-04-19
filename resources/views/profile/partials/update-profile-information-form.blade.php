<section>
    <header>
        <h2 class="zz-section-title">بيانات الحساب</h2>
        <p class="mt-1 text-sm text-[#666157]">حدّث اسم الحساب والبريد الإلكتروني.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="الاسم" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-[#5d584d]">
                        البريد لسه مش متأكد.
                        <button form="send-verification" class="font-semibold text-[#6f7f43] underline hover:text-[#5a6838]">ابعت رسالة تأكيد جديدة</button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-[#3f5a21]">بعتنالك لينك التفعيل على البريد.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>حفظ البيانات</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-[#5d584d]">تم الحفظ.</p>
            @endif
        </div>
    </form>
</section>
