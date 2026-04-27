<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;

class PublicMenuRedirectController extends Controller
{
    public function redirect(string $code): RedirectResponse
    {
        $restaurant = Restaurant::query()
            ->where('permanent_qr_code', $code)
            ->firstOrFail();

        $slug = $restaurant->menuSetting?->slug;

        abort_unless($slug, 404);

        return redirect()->route('menu.show', ['slug' => $slug]);
    }
}
