<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\UpdateMenuSettingsRequest;
use App\Http\Requests\Settings\UpdateRestaurantSettingsRequest;
use Illuminate\Database\QueryException;
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

        return view('settings.index', [
            'restaurant' => $restaurant,
            'menuUrl' => $menuUrl,
            'themes' => config('menu_themes'),
        ]);
    }

    public function updateRestaurant(UpdateRestaurantSettingsRequest $request): RedirectResponse
    {
        $restaurant = $request->user()->restaurant;

        $logoPath = $restaurant->logo_path;
        $bannerPath = $restaurant->banner_path;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('restaurants/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($bannerPath) {
                Storage::disk('public')->delete($bannerPath);
            }
            $bannerPath = $request->file('banner')->store('restaurants/banners', 'public');
        }

        $restaurant->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'description' => $request->description,
            'logo_path' => $logoPath,
            'banner_path' => $bannerPath,
        ]);

        return back()->with('success', 'بيانات المطعم اتحدثت.');
    }

    public function updateMenu(UpdateMenuSettingsRequest $request): RedirectResponse
    {
        try {
            $request->user()->restaurant->menuSetting->update([
                'slug' => str($request->slug)->lower()->slug('-')->value(),
                'is_public' => $request->boolean('is_public', true),
                'active_theme' => $request->active_theme,
            ]);
        } catch (QueryException $exception) {
            if ((string) $exception->getCode() === '23000') {
                return back()->withInput()->withErrors([
                    'slug' => 'اللينك ده متاخد بالفعل، جرّب اسم تاني.',
                ]);
            }

            throw $exception;
        }

        return back()->with('success', 'إعدادات المنيو اتحفظت.');
    }

    public function qrSvg()
    {
        $slug = auth()->user()->restaurant->menuSetting->slug;
        $url = route('menu.show', $slug);

        return response(QrCode::format('svg')->size(360)->margin(1)->generate($url), 200)
            ->header('Content-Type', 'image/svg+xml');
    }
}
