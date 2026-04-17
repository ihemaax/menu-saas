<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\UpdateMenuSettingsRequest;
use App\Http\Requests\Settings\UpdateRestaurantSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingsController extends Controller
{
    public function index(): View
    {
        $restaurant = auth()->user()->restaurant()->with('menuSetting')->firstOrFail();
        $menuUrl = route('menu.show', $restaurant->menuSetting->slug);

        return view('settings.index', compact('restaurant', 'menuUrl'));
    }

    public function updateRestaurant(UpdateRestaurantSettingsRequest $request): RedirectResponse
    {
        $restaurant = $request->user()->restaurant;

        $logoPath = $restaurant->logo_path;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('restaurants/logos', 'public');
        }

        $restaurant->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'description' => $request->description,
            'logo_path' => $logoPath,
        ]);

        return back()->with('success', 'تم تحديث بيانات المطعم.');
    }

    public function updateMenu(UpdateMenuSettingsRequest $request): RedirectResponse
    {
        $request->user()->restaurant->menuSetting->update([
            'slug' => strtolower($request->slug),
            'is_public' => $request->boolean('is_public', true),
        ]);

        return back()->with('success', 'تم تحديث إعدادات المنيو.');
    }

    public function qrSvg()
    {
        $slug = auth()->user()->restaurant->menuSetting->slug;
        $url = route('menu.show', $slug);

        return response(QrCode::format('svg')->size(360)->margin(1)->generate($url), 200)
            ->header('Content-Type', 'image/svg+xml');
    }
}
