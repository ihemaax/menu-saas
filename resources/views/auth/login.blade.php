<x-guest-layout>
    <div class="zz-auth-head">
        <h1 class="zz-auth-title">تسجيل الدخول</h1>
        <p class="zz-auth-text">أهلاً بعودتك 👋 ادخل بياناتك واستكمل إدارة مطعمك من لوحة Osirix.</p>
    </div>

    @if (session('status'))
        <x-auth-session-status class="zz-auth-alert-success" :status="session('status')" />
    @endif

    @if ($errors->any())
        <div class="zz-auth-alert-error">
            <p class="font-semibold">راجع البيانات قبل تسجيل الدخول:</p>
            <ul class="mt-2 list-inside list-disc space-y-1 text-xs sm:text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="zz-auth-form">
        @csrf

        <div>
            <label class="zz-auth-label" for="email">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="zz-auth-input @error('email') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror"
                required
                autofocus
                autocomplete="username"
                placeholder="name@restaurant.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label class="zz-auth-label" for="password">كلمة المرور</label>
            <input
                id="password"
                type="password"
                name="password"
                class="zz-auth-input @error('password') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <label class="zz-auth-remember">
            <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
            تذكرني على هذا الجهاز
        </label>

        <button class="zz-auth-submit">تسجيل الدخول</button>

        <div class="zz-auth-links">
            <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
            <a href="{{ route('register') }}">إنشاء حساب جديد</a>
        </div>
    </form>
</x-guest-layout>
