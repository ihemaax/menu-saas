<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    public function index(): View
    {
        $restaurants = Restaurant::query()
            ->with(['users:id,name,email,restaurant_id', 'menuSetting:id,restaurant_id,slug,is_public'])
            ->withCount(['categories', 'products'])
            ->latest()
            ->get();

        return view('owner.dashboard', [
            'restaurants' => $restaurants,
        ]);
    }

    public function updateSubscription(Request $request, Restaurant $restaurant): RedirectResponse
    {
        $validated = $request->validate([
            'subscription_status' => ['required', Rule::in(['active', 'suspended', 'expired'])],
            'subscription_starts_at' => ['nullable', 'date'],
            'subscription_ends_at' => ['nullable', 'date', 'after_or_equal:subscription_starts_at'],
        ]);

        $restaurant->update([
            'subscription_status' => $validated['subscription_status'],
            'subscription_starts_at' => $validated['subscription_starts_at'] ?? null,
            'subscription_ends_at' => $validated['subscription_ends_at'] ?? null,
        ]);

        return back()->with('success', 'تم تحديث حالة الاشتراك بنجاح.');
    }
}
