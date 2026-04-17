<x-guest-layout>
    <h1 class="text-2xl font-extrabold">إنشاء حساب جديد</h1>
    <form method="POST" action="{{ route('register') }}" class="mt-5 space-y-4">
        @csrf
        <div><label class="zz-label">الاسم</label><input name="name" class="zz-input" value="{{ old('name') }}" required></div>
        <div><label class="zz-label">البريد الإلكتروني</label><input type="email" name="email" class="zz-input" value="{{ old('email') }}" required></div>
        <div><label class="zz-label">كلمة المرور</label><input type="password" name="password" class="zz-input" required></div>
        <div><label class="zz-label">تأكيد كلمة المرور</label><input type="password" name="password_confirmation" class="zz-input" required></div>
        <button class="zz-btn-primary w-full">تسجيل</button>
        <a href="{{ route('login') }}" class="block text-center text-sm text-teal-700">لديك حساب بالفعل؟ دخول</a>
    </form>
</x-guest-layout>
