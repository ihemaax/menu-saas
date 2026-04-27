<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $restaurant = auth()->user()->restaurant()->with('menuSetting')->firstOrFail();

        $stats = [
            'categories_count' => $restaurant->categories()->count(),
            'products_count' => $restaurant->products()->count(),
            'available_products_count' => $restaurant->products()->where('is_available', true)->count(),
            'featured_products_count' => $restaurant->products()->where('is_featured', true)->count(),
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
