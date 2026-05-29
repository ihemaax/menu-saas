<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $restaurant = auth()->user()->restaurant()
            ->with('menuSetting')
            ->withCount([
                'categories',
                'products',
                'products as available_products_count' => fn ($query) => $query->where('is_available', true),
                'products as featured_products_count' => fn ($query) => $query->where('is_featured', true),
            ])
            ->firstOrFail();

        $stats = [
            'categories_count' => $restaurant->categories_count,
            'products_count' => $restaurant->products_count,
            'available_products_count' => $restaurant->available_products_count,
            'featured_products_count' => $restaurant->featured_products_count,
        ];

        return view('dashboard', [
            'restaurant' => $restaurant,
            'menuUrl' => route('menu.show', $restaurant->menuSetting->slug),
            'permanentQrUrl' => $restaurant->permanentQrUrl(),
            'qrDesignPreviewUrl' => route('settings.menu.qr-design.preview'),
            'qrDesignDownloadUrl' => route('settings.menu.qr-design.download'),
            'stats' => $stats,
        ]);
    }
}
