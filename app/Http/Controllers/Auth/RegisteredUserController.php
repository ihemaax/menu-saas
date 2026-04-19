<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $normalizedPhone = preg_replace('/\D+/', '', (string) $request->string('phone'));
        $request->merge(['phone' => $normalizedPhone]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني غير صحيح.',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقًا، جرّب تسجيل الدخول مباشرة.',
            'phone.required' => 'رقم الموبايل مطلوب.',
            'phone.regex' => 'رقم الموبايل غير صحيح. اكتب رقمًا من 10 إلى 15 رقم.',
            'phone.unique' => 'رقم الموبايل مسجل مسبقًا، استخدم رقمًا آخر أو سجّل الدخول مباشرة.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_super_admin' => strcasecmp($request->string('email')->toString(), (string) config('app.super_admin_email')) === 0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('onboarding.create', absolute: false));
    }
}
