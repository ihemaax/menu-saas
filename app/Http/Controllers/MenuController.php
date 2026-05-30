<?php

namespace App\Http\Controllers;

use App\Models\MenuVisit;
use App\Models\MenuSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function show(Request $request, string $slug): View
    {
        $menuSetting = MenuSetting::query()
            ->with('restaurant')
            ->where('slug', $slug)
            ->where('is_public', true)
            ->whereHas('restaurant', fn ($query) => $query
                ->where('subscription_status', 'active')
                ->where(fn ($sub) => $sub->whereNull('subscription_ends_at')->orWhere('subscription_ends_at', '>', now())))
            ->firstOrFail();

        $restaurant = $menuSetting->restaurant;

        $this->trackVisit($request, $menuSetting);

        $categories = $restaurant->categories()
            ->where('is_active', true)
            ->with(['products' => fn ($query) => $query
                ->where('is_available', true)
                ->orderBy('sort_order')
                ->orderBy('id')])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $theme = in_array($menuSetting->theme, ['classy', 'tree', 'sipchill', 'ng', 'paper'], true) ? $menuSetting->theme : 'classy';
        $view = match ($theme) {
            'tree' => 'menu.tree',
            'sipchill' => 'menu.sipchill',
            'ng' => 'menu.ng',
            'paper' => 'menu.paper',
            default => 'menu.show',
        };

        $seoTitle = "{$restaurant->name} | المنيو";
        $seoDescription = $restaurant->description
            ?: "شوف منيو {$restaurant->name} والأسعار والأقسام من Osirix.";
        $seoCanonical = route('menu.show', $menuSetting->slug);
        $seoImage = $restaurant->banner_path
            ? asset('storage/'.$restaurant->banner_path)
            : ($restaurant->logo_path ? asset('storage/'.$restaurant->logo_path) : asset('osirix-logo.svg'));
        $seoType = 'restaurant.menu';

        return view($view, compact(
            'restaurant',
            'categories',
            'menuSetting',
            'seoTitle',
            'seoDescription',
            'seoCanonical',
            'seoImage',
            'seoType'
        ));
    }

    private function trackVisit(Request $request, MenuSetting $menuSetting): void
    {
        $userAgent = (string) $request->userAgent();

        if ($this->isBot($userAgent)) {
            return;
        }

        $now = now();
        $fingerprint = implode('|', [
            $request->ip() ?: 'unknown-ip',
            $userAgent ?: 'unknown-agent',
            $request->headers->get('accept-language', 'unknown-language'),
        ]);

        $visitorHash = hash_hmac('sha256', $fingerprint, (string) config('app.key'));
        $recentVisitExists = MenuVisit::query()
            ->where('restaurant_id', $menuSetting->restaurant_id)
            ->where('visitor_hash', $visitorHash)
            ->where('visited_at', '>=', $now->copy()->subMinutes(30))
            ->exists();

        if ($recentVisitExists) {
            return;
        }

        MenuVisit::query()->create([
            'restaurant_id' => $menuSetting->restaurant_id,
            'menu_setting_id' => $menuSetting->id,
            'visited_on' => $now->toDateString(),
            'visited_at' => $now,
            'visitor_hash' => $visitorHash,
            'ip_hash' => $request->ip() ? hash_hmac('sha256', $request->ip(), (string) config('app.key')) : null,
            'user_agent_hash' => $userAgent !== '' ? hash_hmac('sha256', $userAgent, (string) config('app.key')) : null,
            'device_type' => $this->detectDeviceType($userAgent),
            'source' => $this->detectSource((string) $request->headers->get('referer')),
            'path' => $request->path(),
            'referer' => $request->headers->get('referer'),
        ]);
    }

    private function detectDeviceType(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);

        if (str_contains($userAgent, 'tablet') || str_contains($userAgent, 'ipad')) {
            return 'tablet';
        }

        if (str_contains($userAgent, 'mobile') || str_contains($userAgent, 'android') || str_contains($userAgent, 'iphone')) {
            return 'mobile';
        }

        return $userAgent === '' ? 'unknown' : 'desktop';
    }

    private function detectSource(string $referer): ?string
    {
        $referer = strtolower($referer);

        if ($referer === '') {
            return null;
        }

        return match (true) {
            str_contains($referer, 'wa.me'), str_contains($referer, 'whatsapp') => 'whatsapp',
            str_contains($referer, 'facebook'), str_contains($referer, 'fb.') => 'facebook',
            str_contains($referer, 'instagram') => 'instagram',
            str_contains($referer, 'google') => 'google',
            default => 'other',
        };
    }

    private function isBot(string $userAgent): bool
    {
        if ($userAgent === '') {
            return false;
        }

        return str($userAgent)->lower()->contains([
            'bot',
            'crawler',
            'spider',
            'slurp',
            'facebookexternalhit',
            'preview',
            'whatsapp',
            'telegrambot',
        ]);
    }
}
