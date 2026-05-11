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

        $theme = in_array($menuSetting->theme, ['classy', 'tree', 'sipchill'], true) ? $menuSetting->theme : 'classy';
        $view = match ($theme) {
            'tree' => 'menu.tree',
            'sipchill' => 'menu.sipchill',
            default => 'menu.show',
        };

        return view($view, compact('restaurant', 'categories', 'menuSetting'));
    }
}
