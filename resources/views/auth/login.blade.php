<x-guest-layout>
    <div class="mb-6">
        <p class="mb-3 inline-flex items-center gap-2 rounded-full border border-[#c9a84c]/20 bg-[#c9a84c]/8 px-3 py-1.5 text-xs font-black text-[#8b6914]">
            <i class="fa-solid fa-shield-halved text-[10px]"></i>
            دخول صاحب المكان
        </p>
        <h1 class="text-[1.7rem] font-black leading-tight text-[#1c1710]">نورت تاني</h1>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#6b5f4d]">
            اكتب بياناتك وادخل على اللوحة عشان تظبط المنيو والأسعار والـ QR.
        </p>
    </div>

    @if (session('status'))
        <x-auth-session-status class="mb-5 rounded-xl border border-[#b8ddd6] bg-[#f0faf8] px-4 py-3 text-sm font-semibold text-[#236a60]" :status="session('status')" />
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-[#f0d0c8] bg-[#fdf3f0] px-4 py-3 text-sm text-[#9a3a28]">
            <p class="font-black">في حاجة محتاجة تتراجع:</p>
            <ul class="mt-2 list-inside list-disc space-y-1 text-xs font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('auth.google.redirect') }}" class="mb-5 inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-5 py-3.5 text-sm font-black text-[#1c1710] shadow-[0_2px_8px_rgba(0,0,0,0.03)] transition hover:border-[#c9a84c]/40 hover:bg-[#c9a84c]/5 focus:outline-none focus:ring-2 focus:ring-[#c9a84c]/20">
        <i class="fa-brands fa-google text-[#c0503c]"></i>
        الدخول بحساب جوجل
    </a>

    <div class="mb-5 flex items-center gap-3 text-xs font-black text-[#6b5f4d]/50">
        <span class="h-px flex-1 bg-gradient-to-l from-[#c9a84c]/20 to-transparent"></span>
        <span>أو بالإيميل</span>
        <span class="h-px flex-1 bg-gradient-to-r from-[#c9a84c]/20 to-transparent"></span>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="mb-2 block text-sm font-black text-[#1c1710]" for="email">الإيميل</label>
            <div class="relative">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-12 py-3.5 text-sm font-semibold text-[#1c1710] outline-none transition placeholder:text-[#6b5f4d]/40 focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[#c9a84c]/15 @error('email') !border-[#c0503c] !ring-[#f0d0c8] @enderror"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="name@brand.com"
                >
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8b6914]/50">
                    <i class="fa-regular fa-envelope"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <div class="mb-2 flex items-center justify-between gap-3">
                <label class="block text-sm font-black text-[#1c1710]" for="password">الباسورد</label>
                <a href="{{ route('password.request') }}" class="shrink-0 text-xs font-bold text-[#8b6914] transition hover:text-[#6d5210] hover:underline">ناسي الباسورد؟</a>
            </div>
            <div class="relative">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    class="w-full rounded-xl border border-[#e8e0ce] bg-[#faf7f0] px-12 py-3.5 text-sm font-semibold text-[#1c1710] outline-none transition placeholder:text-[#6b5f4d]/40 focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[#c9a84c]/15 @error('password') !border-[#c0503c] !ring-[#f0d0c8] @enderror"
                    required
                    autocomplete="current-password"
                    placeholder="اكتب الباسورد"
                >
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8b6914]/50">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <button type="button" @click="show = !show" class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#6b5f4d]/50 transition hover:text-[#8b6914]" aria-label="إظهار أو إخفاء الباسورد">
                    <i class="fa-regular" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label class="flex w-fit cursor-pointer items-center gap-2 text-sm font-bold text-[#6b5f4d]">
            <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="h-4 w-4 rounded border-[#e8e0ce] text-[#c9a84c] focus:ring-[#c9a84c]/30">
            <span>خليّني فاكر على الجهاز ده</span>
        </label>

        <button class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-l from-[#c9a84c] to-[#dfc06e] px-5 py-4 text-base font-black text-[#1c1710] shadow-[0_10px_28px_rgba(201,168,76,0.25)] transition hover:shadow-[0_14px_36px_rgba(201,168,76,0.35)] focus:outline-none focus:ring-2 focus:ring-[#c9a84c]/30 active:scale-[0.98]">
            <i class="fa-solid fa-right-to-bracket"></i>
            ادخل على اللوحة
        </button>

        <div class="rounded-xl border border-[#e8e0ce] bg-[#faf7f0] p-4 text-center">
            <p class="text-sm font-semibold text-[#6b5f4d]">
                لسه معندكش حساب؟
                <a href="{{ route('register') }}" class="font-black text-[#8b6914] transition hover:text-[#6d5210] hover:underline">اعمل حساب جديد</a>
            </p>
        </div>
    </form>
</x-guest-layout>
