<x-guest-layout>
    <h1 class="text-2xl font-extrabold">نرجّعلك الدخول بسرعة</h1>
    <p class="mt-1 text-sm text-slate-500">اكتب الإيميل، ونبعتلك لينك تغيير الباسورد.</p>
    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf
        <div><label class="zz-label">الإيميل</label><input type="email" name="email" class="zz-input" required></div>
        <button class="zz-btn-primary w-full">ابعت اللينك</button>
    </form>
</x-guest-layout>
