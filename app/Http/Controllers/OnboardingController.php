<?php

namespace App\Http\Controllers;

use App\Http\Requests\Onboarding\StoreOnboardingRequest;
use App\Models\MenuSetting;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (auth()->user()->restaurant_id) {
            return redirect()->route('dashboard');
        }

        return view('onboarding.create');
    }

    public function store(StoreOnboardingRequest $request): RedirectResponse
    {
        $user = $request->user();

        DB::transaction(function () use ($request, $user): void {
            $logoPath = $request->file('logo')?->store('restaurants/logos', 'public');

            $restaurant = Restaurant::create([
                'name' => $request->string('restaurant_name')->toString(),
                'phone' => $request->filled('phone') ? $request->string('phone')->toString() : null,
                'description' => $request->filled('description') ? $request->string('description')->toString() : null,
                'logo_path' => $logoPath,
            ]);

            $user->update(['restaurant_id' => $restaurant->id]);

            MenuSetting::create([
                'restaurant_id' => $restaurant->id,
                'slug' => strtolower($request->string('slug')->toString()),
                'is_public' => $request->boolean('is_public', true),
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'تم تجهيز مطعمك بنجاح.');
    }
}
