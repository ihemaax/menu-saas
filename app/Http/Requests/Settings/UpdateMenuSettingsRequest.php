<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->restaurant_id !== null;
    }

    public function rules(): array
    {
        $menuSettingId = optional(auth()->user()->restaurant?->menuSetting)->id;

        return [
            'slug' => ['required', 'string', 'min:3', 'max:60', 'regex:/^[a-z0-9-]+$/', Rule::unique('menu_settings', 'slug')->ignore($menuSettingId)],
            'is_public' => ['nullable', 'boolean'],
            'theme' => ['required', 'string', Rule::in(['classy', 'tree'])],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'اكتب الـ slug بالإنجليزي فقط (a-z, 0-9, -) بدون أي حروف عربية.',
        ];
    }
}
