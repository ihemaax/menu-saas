<x-guest-layout>
    <h1 class="text-2xl font-extrabold">تسجيل الدخول</h1>
    <form method="POST" action="{{ route('login') }}" class="mt-5 space-y-4">
        @csrf
        <div><label class="zz-label">البريد الإلكتروني</label><input type="email" name="email" value="{{ old('email') }}" class="zz-input" required></div>
        <div><label class="zz-label">كلمة المرور</label><input type="password" name="password" class="zz-input" required></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> تذكرني</label>
        <button class="zz-btn-primary w-full">دخول</button>
        <div class="flex justify-between text-sm">
            <a href="{{ route('password.request') }}" class="text-teal-700">نسيت كلمة المرور؟</a>
            <a href="{{ route('register') }}" class="text-teal-700">إنشاء حساب</a>
        </div>
    </form>
</x-guest-layout>
