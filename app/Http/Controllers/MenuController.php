<?php

namespace App\Http\Controllers;

use App\Models\MenuSetting;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function show(string $slug): View
    {
        $menuSetting = MenuSetting::where('slug', $slug)
            ->where('is_public', true)
            ->firstOrFail();

        $restaurant = $menuSetting->restaurant()->firstOrFail();

        $categories = $restaurant->categories()
            ->where('is_active', true)
            ->with(['products' => fn ($query) => $query->where('is_available', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = $restaurant->products()
            ->where('is_available', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('menu.show', compact('restaurant', 'categories', 'featuredProducts'));
    }
}
