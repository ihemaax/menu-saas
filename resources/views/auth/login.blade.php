<x-guest-layout>
    <h1 class="text-2xl font-extrabold">أهلاً بعودتك</h1>
    <p class="mt-1 text-sm text-slate-500">سجّل دخولك وكمل إدارة المنيو بسهولة.</p>

    @if (session('status'))
        <x-auth-session-status class="mt-4 rounded-xl border border-[#c9ddb0] bg-[#eef6e1] px-3 py-2 text-right !text-[#3f5a21]" :status="session('status')" />
    @endif

    @if ($errors->any())
        <div class="mt-4 rounded-2xl border border-[#efc5bd] bg-[#fbe9e5] px-4 py-3 text-sm text-[#8b3b2e]">
            <p class="font-semibold">في مشكلة محتاجة تعديل قبل الدخول:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label class="zz-label" for="email">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="zz-input @error('email') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror"
                required
                autofocus
                autocomplete="username"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label class="zz-label" for="password">كلمة المرور</label>
            <input
                id="password"
                type="password"
                name="password"
                class="zz-input @error('password') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror"
                required
                autocomplete="current-password"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
            تذكرني على هذا الجهاز
        </label>

        <button class="zz-btn-primary w-full">تسجيل الدخول</button>

        <div class="flex justify-between text-sm">
            <a href="{{ route('password.request') }}" class="text-teal-700">نسيت كلمة المرور؟</a>
            <a href="{{ route('register') }}" class="text-teal-700">إنشاء حساب جديد</a>
        </div>
    </form>
</x-guest-layout>
