<x-guest-layout>
    <div class="mb-6">
        <p class="mb-3 inline-flex items-center gap-2 rounded-full border border-[#c9a84c]/20 bg-[#c9a84c]/8 px-3 py-1.5 text-xs font-black text-[#8b6914]">
            <i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i>
            حساب جديد لمكانك
        </p>
        <h1 class="text-[1.7rem] font-black leading-tight text-[#1c1710]">يلا نجهز حسابك</h1>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#6b5f4d]">
            سجل بياناتك، وبعدها هتضيف اسم المكان والأقسام والأصناف براحتك من اللوحة.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-[#f0d0c8] bg-[#fdf3f0] px-4 py-3 text-sm text-[#9a3a28]">
            <p class="font-black">راجع البيانات دي قبل ما نكمل:</p>
            <ul class="mt-2 list-inside list-disc space-y-1 text-xs font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('auth.google.redirect') }}" class="mb-5 inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-5 py-3.5 text-sm font-black text-[#1c1710] shadow-[0_2px_8px_rgba(0,0,0,0.03)] transition hover:border-[#c9a84c]/40 hover:bg-[#c9a84c]/5 focus:outline-none focus:ring-2 focus:ring-[#c9a84c]/20">
        <i class="fa-brands fa-google text-[#c0503c]"></i>
        التسجيل بحساب جوجل
    </a>

    <div class="mb-5 flex items-center gap-3 text-xs font-black text-[#6b5f4d]/50">
        <span class="h-px flex-1 bg-gradient-to-l from-[#c9a84c]/20 to-transparent"></span>
        <span>أو بالبيانات</span>
        <span class="h-px flex-1 bg-gradient-to-r from-[#c9a84c]/20 to-transparent"></span>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="mb-2 block text-sm font-black text-[#1c1710]" for="name">اسمك</label>
            <div class="relative">
                <input id="name" name="name" class="w-full rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-12 py-3.5 text-sm font-semibold text-[#1c1710] outline-none transition placeholder:text-[#6b5f4d]/40 focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[#c9a84c]/15 @error('name') !border-[#c0503c] !ring-[#f0d0c8] @enderror" value="{{ old('name') }}" required autocomplete="name" placeholder="اسم صاحب الحساب">
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8b6914]/50">
                    <i class="fa-regular fa-user"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-[#1c1710]" for="email">الإيميل</label>
            <div class="relative">
                <input id="email" type="email" name="email" class="w-full rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-12 py-3.5 text-sm font-semibold text-[#1c1710] outline-none transition placeholder:text-[#6b5f4d]/40 focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[#c9a84c]/15 @error('email') !border-[#c0503c] !ring-[#f0d0c8] @enderror" value="{{ old('email') }}" required autocomplete="username" placeholder="name@brand.com">
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8b6914]/50">
                    <i class="fa-regular fa-envelope"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-[#1c1710]" for="phone">رقم الموبايل</label>
            <div class="relative">
                <input id="phone" type="tel" name="phone" class="w-full rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-12 py-3.5 text-sm font-semibold text-[#1c1710] outline-none transition placeholder:text-[#6b5f4d]/40 focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[#c9a84c]/15 @error('phone') !border-[#c0503c] !ring-[#f0d0c8] @enderror" value="{{ old('phone') }}" required inputmode="numeric" placeholder="مثال: 01012345678" autocomplete="tel">
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8b6914]/50">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-black text-[#1c1710]" for="password">الباسورد</label>
                <div class="relative">
                    <input id="password" type="password" name="password" class="w-full rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-12 py-3.5 text-sm font-semibold text-[#1c1710] outline-none transition placeholder:text-[#6b5f4d]/40 focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[#c9a84c]/15 @error('password') !border-[#c0503c] !ring-[#f0d0c8] @enderror" required autocomplete="new-password" placeholder="8 حروف أو أكتر">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8b6914]/50">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-[#1c1710]" for="password_confirmation">أكد الباسورد</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="w-full rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-12 py-3.5 text-sm font-semibold text-[#1c1710] outline-none transition placeholder:text-[#6b5f4d]/40 focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[#c9a84c]/15 @error('password_confirmation') !border-[#c0503c] !ring-[#f0d0c8] @enderror" required autocomplete="new-password" placeholder="اكتبه تاني">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8b6914]/50">
                        <i class="fa-solid fa-key"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <button class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-l from-[#1c1710] to-[#2a2318] px-5 py-4 text-base font-black text-[#f0e6ce] shadow-[0_10px_28px_rgba(28,23,16,0.2)] transition hover:shadow-[0_14px_36px_rgba(28,23,16,0.28)] focus:outline-none focus:ring-2 focus:ring-[#c9a84c]/25 active:scale-[0.98]">
            <i class="fa-solid fa-circle-plus"></i>
            اعمل الحساب
        </button>

        <div class="rounded-xl border border-[#e8e0ce] bg-[#faf7f0] p-4 text-center">
            <p class="text-sm font-semibold text-[#6b5f4d]">
                عندك حساب قبل كده؟
                <a href="{{ route('login') }}" class="font-black text-[#8b6914] transition hover:text-[#6d5210] hover:underline">ادخل من هنا</a>
            </p>
        </div>
    </form>
</x-guest-layout>
