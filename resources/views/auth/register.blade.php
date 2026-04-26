<x-guest-layout>
    <div class="zz-auth-head">
        <h1 class="zz-auth-title">إنشاء حساب جديد</h1>
        <p class="zz-auth-text">ابدأ مع Osirix خلال دقيقة واحدة، وبعدها تقدر تدير مطعمك بالكامل من الداشبورد.</p>
    </div>

    @if ($errors->any())
        <div class="zz-auth-alert-error">
            <p class="font-semibold">راجع البيانات دي قبل إنشاء الحساب:</p>
            <ul class="mt-2 list-inside list-disc space-y-1 text-xs sm:text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="zz-auth-form">
        @csrf

        <div>
            <label class="zz-auth-label" for="name">الاسم</label>
            <input id="name" name="name" class="zz-auth-input @error('name') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" value="{{ old('name') }}" required autocomplete="name" placeholder="اسم صاحب الحساب">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <label class="zz-auth-label" for="email">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" class="zz-auth-input @error('email') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" value="{{ old('email') }}" required autocomplete="username" placeholder="name@restaurant.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label class="zz-auth-label" for="phone">رقم الموبايل</label>
            <input id="phone" type="tel" name="phone" class="zz-auth-input @error('phone') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" value="{{ old('phone') }}" required inputmode="numeric" placeholder="مثال: 01012345678" autocomplete="tel">
            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>

        <div>
            <label class="zz-auth-label" for="password">كلمة المرور</label>
            <input id="password" type="password" name="password" class="zz-auth-input @error('password') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" required autocomplete="new-password" placeholder="8 أحرف أو أكثر">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <label class="zz-auth-label" for="password_confirmation">تأكيد كلمة المرور</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="zz-auth-input @error('password_confirmation') !border-[#c84e42] !ring-2 !ring-[#f3c2bc] @enderror" required autocomplete="new-password" placeholder="أعد كتابة كلمة المرور">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <button class="zz-auth-submit">إنشاء الحساب</button>
        <a href="{{ route('login') }}" class="zz-auth-single-link">عندك حساب؟ سجّل دخولك من هنا</a>
    </form>
</x-guest-layout>
