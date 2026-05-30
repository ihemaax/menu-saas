<?php

namespace App\Http\Controllers;

use App\Models\MenuVisit;
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

        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();
        $lastSevenDaysStart = now()->subDays(6)->toDateString();
        $lastThirtyDaysStart = now()->subDays(29)->toDateString();

        $visitStats = [
            'today' => MenuVisit::query()
                ->where('restaurant_id', $restaurant->id)
                ->whereDate('visited_on', $today)
                ->count(),
            'yesterday' => MenuVisit::query()
                ->where('restaurant_id', $restaurant->id)
                ->whereDate('visited_on', $yesterday)
                ->count(),
            'last_7_days' => MenuVisit::query()
                ->where('restaurant_id', $restaurant->id)
                ->whereDate('visited_on', '>=', $lastSevenDaysStart)
                ->count(),
            'last_30_days' => MenuVisit::query()
                ->where('restaurant_id', $restaurant->id)
                ->whereDate('visited_on', '>=', $lastThirtyDaysStart)
                ->count(),
            'mobile_today' => MenuVisit::query()
                ->where('restaurant_id', $restaurant->id)
                ->whereDate('visited_on', $today)
                ->where('device_type', 'mobile')
                ->count(),
        ];

        $visitsByDay = MenuVisit::query()
            ->where('restaurant_id', $restaurant->id)
            ->whereDate('visited_on', '>=', $lastSevenDaysStart)
            ->selectRaw('visited_on, count(*) as total')
            ->groupBy('visited_on')
            ->pluck('total', 'visited_on');

        $visitChart = collect(range(6, 0))->map(function (int $daysAgo) use ($visitsByDay) {
            $date = now()->subDays($daysAgo);

            return [
                'label' => $date->translatedFormat('D'),
                'date' => $date->toDateString(),
                'total' => (int) ($visitsByDay[$date->toDateString()] ?? 0),
            ];
        });

        return view('dashboard', [
            'restaurant' => $restaurant,
            'menuUrl' => route('menu.show', $restaurant->menuSetting->slug),
            'permanentQrUrl' => $restaurant->permanentQrUrl(),
            'qrDesignPreviewUrl' => route('settings.menu.qr-design.preview'),
            'qrDesignDownloadUrl' => route('settings.menu.qr-design.download'),
            'stats' => $stats,
            'visitStats' => $visitStats,
            'visitChart' => $visitChart,
        ]);
    }
}
