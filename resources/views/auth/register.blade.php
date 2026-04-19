<x-guest-layout>
    <h1 class="text-2xl font-extrabold">إنشاء حساب جديد</h1>
    <p class="mt-1 text-sm text-slate-500">أنشئ حسابك وابدأ تجهيز المنيو بشكل احترافي.</p>

    @if ($errors->any())
        <div class="mt-4 rounded-2xl border border-[#efc5bd] bg-[#fbe9e5] px-4 py-3 text-sm text-[#8b3b2e]">
            <p class="font-semibold">راجع البيانات دي قبل إنشاء الحساب:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label class="zz-label" for="name">الاسم</label>
            <input id="name" name="name" class="zz-input @error('name') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" value="{{ old('name') }}" required autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <label class="zz-label" for="email">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" class="zz-input @error('email') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label class="zz-label" for="phone">رقم الموبايل</label>
            <input id="phone" type="tel" name="phone" class="zz-input @error('phone') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" value="{{ old('phone') }}" required inputmode="numeric" placeholder="مثال: 01012345678" autocomplete="tel">
            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>

        <div>
            <label class="zz-label" for="password">كلمة المرور</label>
            <input id="password" type="password" name="password" class="zz-input @error('password') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <label class="zz-label" for="password_confirmation">تأكيد كلمة المرور</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="zz-input @error('password_confirmation') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <button class="zz-btn-primary w-full">إنشاء الحساب</button>
        <a href="{{ route('login') }}" class="block text-center text-sm text-teal-700">عندك حساب؟ سجّل دخولك من هنا</a>
    </form>
</x-guest-layout>
