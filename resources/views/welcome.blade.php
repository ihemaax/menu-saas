<x-guest-layout>
    <div class="space-y-4 text-center">
        <p class="text-xs font-semibold text-teal-700">نسخة تجريبية</p>
        <h1 class="text-3xl font-extrabold text-slate-900">خلّي منيو مكانك يبان من أول نظرة.</h1>
        <p class="text-slate-600">سجل حسابك وطلّع لينك منيو مرتب يتفتح بسرعة على أي موبايل.</p>
        <div class="flex flex-col gap-3 sm:flex-row">
            <a class="zz-btn-primary w-full" href="{{ route('register') }}">اعمل حساب</a>
            <a class="zz-btn-secondary w-full" href="{{ route('login') }}">دخول</a>
        </div>
    </div>
</x-guest-layout>
