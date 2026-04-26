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
            'slug' => ['required', 'string', 'alpha_dash', 'min:3', 'max:60', Rule::unique('menu_settings', 'slug')->ignore($menuSettingId)],
            'is_public' => ['nullable', 'boolean'],
            'theme' => ['required', 'string', Rule::in(['classy', 'tree'])],
        ];
    }
}
