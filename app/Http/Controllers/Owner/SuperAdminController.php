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
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $status = $request->string('status')->toString();

        $restaurants = Restaurant::query()
            ->with(['users:id,name,email,restaurant_id', 'menuSetting:id,restaurant_id,slug,is_public'])
            ->withCount(['categories', 'products'])
            ->when($search !== '', function ($query) use ($search): void {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('users', fn ($users) => $users
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"));
            })
            ->when(in_array($status, ['active', 'suspended', 'expired'], true), fn ($query) => $query->where('subscription_status', $status))
            ->latest()
            ->get();

        $allRestaurants = Restaurant::query()->get(['id', 'subscription_status', 'created_at']);

        return view('owner.dashboard', [
            'restaurants' => $restaurants,
            'filters' => [
                'q' => $search,
                'status' => $status,
            ],
            'stats' => [
                'total_restaurants' => $allRestaurants->count(),
                'active_restaurants' => $allRestaurants->where('subscription_status', 'active')->count(),
                'suspended_restaurants' => $allRestaurants->where('subscription_status', 'suspended')->count(),
                'expired_restaurants' => $allRestaurants->where('subscription_status', 'expired')->count(),
                'new_this_month' => $allRestaurants->where('created_at', '>=', now()->startOfMonth())->count(),
            ],
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
