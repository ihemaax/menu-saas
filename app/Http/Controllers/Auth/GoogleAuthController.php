<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (! config('services.google.client_id') || ! config('services.google.client_secret')) {
            throw ValidationException::withMessages([
                'email' => 'تسجيل الدخول بجوجل غير مفعل حاليا. أضف بيانات Google OAuth أولا.',
            ]);
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Throwable) {
            throw ValidationException::withMessages([
                'email' => 'تعذر تسجيل الدخول بجوجل. حاول مرة أخرى.',
            ]);
        }

        $email = Str::lower((string) $googleUser->getEmail());

        if ($email === '') {
            throw ValidationException::withMessages([
                'email' => 'حساب جوجل لم يرجع بريد إلكتروني صالح.',
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: Str::before($email, '@'),
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::password(32)),
                'is_super_admin' => strcasecmp($email, (string) config('app.super_admin_email')) === 0,
            ]);
        } elseif (! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user);

        $request->session()->regenerate();

        if (! $user->restaurant_id && ! $user->isSuperAdmin()) {
            return redirect()->intended(route('onboarding.create', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
