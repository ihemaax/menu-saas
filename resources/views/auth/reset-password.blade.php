<x-guest-layout>
    <h1 class="text-xl font-extrabold">تعيين كلمة مرور جديدة</h1>
    <form method="POST" action="{{ route('password.store') }}" class="mt-5 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div><label class="zz-label">البريد الإلكتروني</label><input type="email" name="email" value="{{ old('email', $request->email) }}" class="zz-input" required></div>
        <div><label class="zz-label">كلمة المرور</label><input type="password" name="password" class="zz-input" required></div>
        <div><label class="zz-label">تأكيد كلمة المرور</label><input type="password" name="password_confirmation" class="zz-input" required></div>
        <button class="zz-btn-primary w-full">حفظ</button>
    </form>
</x-guest-layout>
