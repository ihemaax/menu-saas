<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeController extends Controller
{
    public function index(): View
    {
        $restaurant = auth()->user()->restaurant()->with('menuSetting')->firstOrFail();

        return view('themes.index', [
            'restaurant' => $restaurant,
            'themes' => config('menu_themes'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'theme' => ['required', 'string', 'in:'.implode(',', array_keys(config('menu_themes')))],
        ]);

        $request->user()->restaurant->menuSetting->update([
            'active_theme' => $request->theme,
        ]);

        return back()->with('success', 'الثيم اتفعل بنجاح.');
    }
}
