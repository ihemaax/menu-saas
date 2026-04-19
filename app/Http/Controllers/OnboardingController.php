<?php

namespace App\Http\Controllers;

use App\Http\Requests\Onboarding\StoreOnboardingRequest;
use App\Models\MenuSetting;
use App\Models\Restaurant;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

        try {
            DB::transaction(function () use ($request, $user): void {
                $logoPath = $request->file('logo')?->store('restaurants/logos', 'public');
                $bannerPath = $request->file('banner')?->store('restaurants/banners', 'public');

                $restaurant = Restaurant::create([
                    'name' => $request->string('restaurant_name')->toString(),
                    'phone' => $request->filled('phone') ? $request->string('phone')->toString() : null,
                    'description' => $request->filled('description') ? $request->string('description')->toString() : null,
                    'logo_path' => $logoPath,
                    'banner_path' => $bannerPath,
                    'subscription_status' => 'active',
                    'subscription_starts_at' => now(),
                ]);

                $user->update(['restaurant_id' => $restaurant->id]);

                MenuSetting::create([
                    'restaurant_id' => $restaurant->id,
                    'slug' => $this->normalizeSlug($request->string('slug')->toString()),
                    'is_public' => $request->boolean('is_public', true),
                ]);
            });
        } catch (QueryException $exception) {
            if ((string) $exception->getCode() === '23000') {
                return back()->withInput()->withErrors([
                    'slug' => 'اللينك ده متاخد بالفعل، جرّب اسم تاني.',
                ]);
            }

            throw $exception;
        }

        return redirect()->route('dashboard')->with('success', 'تمام، مطعمك جاهز وإنت دلوقتي على اللوحة.');
    }

    public function checkSlug(Request $request): JsonResponse
    {
        $candidate = $this->normalizeSlug($request->string('slug')->toString());

        if (strlen($candidate) < 3) {
            return response()->json([
                'available' => false,
                'slug' => $candidate,
                'message' => 'اكتب 3 حروف على الأقل.',
            ]);
        }

        $exists = MenuSetting::where('slug', $candidate)->exists();

        return response()->json([
            'available' => ! $exists,
            'slug' => $candidate,
            'message' => $exists ? 'الاسم ده مستخدم، جرّب اقتراح تاني.' : 'ممتاز، اللينك متاح.',
        ]);
    }

    private function normalizeSlug(string $value): string
    {
        return Str::of($value)->lower()->slug('-')->value();
    }
}
