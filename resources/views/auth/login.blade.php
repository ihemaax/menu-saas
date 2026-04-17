<x-guest-layout>
    <h1 class="text-2xl font-extrabold">نورت تاني 👋</h1>
    <p class="mt-1 text-sm text-slate-500">ادخل بياناتك وكمل إدارة منيوك.</p>
    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf
        <div><label class="zz-label">الإيميل</label><input type="email" name="email" value="{{ old('email') }}" class="zz-input" required></div>
        <div><label class="zz-label">الباسورد</label><input type="password" name="password" class="zz-input" required></div>
        <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" name="remember"> افتكرني على الجهاز ده</label>
        <button class="zz-btn-primary w-full">دخول</button>
        <div class="flex justify-between text-sm">
            <a href="{{ route('password.request') }}" class="text-teal-700">نسيت الباسورد؟</a>
            <a href="{{ route('register') }}" class="text-teal-700">حساب جديد</a>
        </div>
    </form>
</x-guest-layout>
