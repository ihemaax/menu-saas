<x-guest-layout>
    <h1 class="text-2xl font-extrabold">باسورد جديد</h1>
    <p class="mt-1 text-sm text-slate-500">اختار باسورد سهل عليك وصعب على غيرك.</p>
    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div><label class="zz-label">الإيميل</label><input type="email" name="email" value="{{ old('email', $request->email) }}" class="zz-input" required></div>
        <div><label class="zz-label">الباسورد</label><input type="password" name="password" class="zz-input" required></div>
        <div><label class="zz-label">تأكيد الباسورد</label><input type="password" name="password_confirmation" class="zz-input" required></div>
        <button class="zz-btn-primary w-full">حفظ</button>
    </form>
</x-guest-layout>
