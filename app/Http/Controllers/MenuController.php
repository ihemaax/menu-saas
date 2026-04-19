<?php

namespace App\Http\Controllers;

use App\Models\MenuSetting;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function show(string $slug): View
    {
        $menuSetting = MenuSetting::query()
            ->where('slug', $slug)
            ->where('is_public', true)
            ->whereHas('restaurant', fn ($query) => $query
                ->where('subscription_status', 'active')
                ->where(fn ($sub) => $sub->whereNull('subscription_ends_at')->orWhere('subscription_ends_at', '>', now())))
            ->firstOrFail();

        $restaurant = $menuSetting->restaurant()->firstOrFail();

        $categories = $restaurant->categories()
            ->where('is_active', true)
            ->with(['products' => fn ($query) => $query->where('is_available', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('menu.show', compact('restaurant', 'categories', 'menuSetting'));
    }
}
