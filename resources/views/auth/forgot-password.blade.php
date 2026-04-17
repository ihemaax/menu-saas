<x-guest-layout>
    <h1 class="text-xl font-extrabold">استرجاع كلمة المرور</h1>
    <p class="mt-2 text-sm text-slate-500">أدخل بريدك الإلكتروني لإرسال رابط إعادة التعيين.</p>
    <form method="POST" action="{{ route('password.email') }}" class="mt-5 space-y-4">
        @csrf
        <div><label class="zz-label">البريد الإلكتروني</label><input type="email" name="email" class="zz-input" required></div>
        <button class="zz-btn-primary w-full">إرسال الرابط</button>
    </form>
</x-guest-layout>
