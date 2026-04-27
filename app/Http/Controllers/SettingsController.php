<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\UpdateMenuSettingsRequest;
use App\Http\Requests\Settings\UpdateRestaurantSettingsRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingsController extends Controller
{
    public function index(): View
    {
        $restaurant = auth()->user()->restaurant()->with('menuSetting')->firstOrFail();
        $menuUrl = route('menu.show', $restaurant->menuSetting->slug);
        $permanentQrUrl = $restaurant->permanentQrUrl();

        return view('settings.index', [
            'restaurant' => $restaurant,
            'menuUrl' => $menuUrl,
            'permanentQrUrl' => $permanentQrUrl,
            'qrDesignPreviewUrl' => route('settings.menu.qr-design.preview'),
            'qrDesignDownloadUrl' => route('settings.menu.qr-design.download'),
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
            'address' => $request->address,
            'description' => $request->description,
            'logo_path' => $logoPath,
            'banner_path' => $bannerPath,
        ]);

        return back()->with('success', 'بيانات المطعم اتحفظت بنجاح.');
    }

    public function updateMenu(UpdateMenuSettingsRequest $request): RedirectResponse
    {
        try {
            $request->user()->restaurant->menuSetting->update([
                'slug' => str($request->slug)->lower()->slug('-')->value(),
                'is_public' => $request->boolean('is_public', true),
                'theme' => $request->input('theme', 'classy'),
            ]);
        } catch (QueryException $exception) {
            if ((string) $exception->getCode() === '23000') {
                return back()->withInput()->withErrors([
                    'slug' => 'اللينك ده متاخد بالفعل، جرّب اسم تاني.',
                ]);
            }

            throw $exception;
        }

        return back()->with('success', 'إعدادات المنيو اتحدثت.');
    }

    public function qrSvg(): Response
    {
        $restaurant = auth()->user()->restaurant;
        $url = $restaurant->permanentQrUrl();

        return response(QrCode::format('svg')->size(360)->margin(1)->generate($url), 200)
            ->header('Content-Type', 'image/svg+xml');
    }

    public function qrPrintDesignPreview(): View
    {
        return view('settings.qr-print-design', $this->buildQrPrintDesignData());
    }

    public function qrPrintDesignDownload(): Response
    {
        $restaurant = auth()->user()->restaurant;

        return response()
            ->view('settings.qr-print-design', $this->buildQrPrintDesignData())
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="qr-print-design-'.$restaurant->id.'.html"');
    }

    private function buildQrPrintDesignData(): array
    {
        $restaurant = auth()->user()->restaurant;
        $qrDataUri = 'data:image/png;base64,'.base64_encode(
            QrCode::format('png')->size(1200)->margin(3)->errorCorrection('H')->generate($restaurant->permanentQrUrl())
        );

        $logoDataUri = null;

        if ($restaurant->logo_path && Storage::disk('public')->exists($restaurant->logo_path)) {
            $logoFile = Storage::disk('public')->get($restaurant->logo_path);
            $logoMime = Storage::disk('public')->mimeType($restaurant->logo_path) ?: 'image/png';
            $logoDataUri = 'data:'.$logoMime.';base64,'.base64_encode($logoFile);
        }

        $restaurantName = trim((string) $restaurant->name);
        $nameHasArabic = preg_match('/\p{Arabic}/u', $restaurantName) === 1;

        return [
            'restaurantName' => $restaurantName,
            'ctaText' => $nameHasArabic ? 'امسح لعرض المنيو' : 'Scan to View Menu',
            'helperText' => $nameHasArabic ? 'استخدم كاميرا الموبايل للوصول السريع' : 'Use your phone camera for instant access',
            'qrDataUri' => $qrDataUri,
            'logoDataUri' => $logoDataUri,
            'isRtl' => $nameHasArabic,
        ];
    }
}
