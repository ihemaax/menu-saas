<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;

class StoreOnboardingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'restaurant_name' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:800'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'slug' => ['required', 'string', 'min:3', 'max:60', 'regex:/^[a-z0-9-]+$/', 'unique:menu_settings,slug'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'اكتب الـ slug بالإنجليزي فقط (a-z, 0-9, -) بدون أي حروف عربية.',
        ];
    }
}
