<x-guest-layout>
    <h1 class="text-2xl font-extrabold">يلا نبدأ ✨</h1>
    <p class="mt-1 text-sm text-slate-500">خطوتين وتبقى جاهز تنزل منيوك للناس.</p>
    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf
        <div><label class="zz-label">اسمك</label><input name="name" class="zz-input" value="{{ old('name') }}" required></div>
        <div><label class="zz-label">الإيميل</label><input type="email" name="email" class="zz-input" value="{{ old('email') }}" required></div>
        <div><label class="zz-label">الباسورد</label><input type="password" name="password" class="zz-input" required></div>
        <div><label class="zz-label">تأكيد الباسورد</label><input type="password" name="password_confirmation" class="zz-input" required></div>
        <button class="zz-btn-primary w-full">إنشاء الحساب</button>
        <a href="{{ route('login') }}" class="block text-center text-sm text-teal-700">عندك حساب؟ ادخل من هنا</a>
    </form>
</x-guest-layout>
