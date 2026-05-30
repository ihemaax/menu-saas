<?php

namespace App\Http\Controllers;

use App\Models\MenuSetting;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $menus = MenuSetting::query()
            ->with('restaurant:id,subscription_status,subscription_ends_at,updated_at')
            ->where('is_public', true)
            ->whereHas('restaurant', fn ($query) => $query
                ->where('subscription_status', 'active')
                ->where(fn ($sub) => $sub->whereNull('subscription_ends_at')->orWhere('subscription_ends_at', '>', now())))
            ->latest('updated_at')
            ->get();

        return response()
            ->view('seo.sitemap', [
                'menus' => $menus,
                'homeUrl' => route('home'),
            ])
            ->header('Content-Type', 'application/xml');
    }
}
