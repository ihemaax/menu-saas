<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\Owner\SuperAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function (): void {
    Route::get('/onboarding', [OnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('/onboarding/slug-check', [OnboardingController::class, 'checkSlug'])->name('onboarding.slug-check');

    Route::middleware(['restaurant.setup', 'restaurant.subscription'])->group(function (): void {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('products', ProductController::class)->except('show');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings/restaurant', [SettingsController::class, 'updateRestaurant'])->name('settings.restaurant.update');
        Route::put('/settings/menu', [SettingsController::class, 'updateMenu'])->name('settings.menu.update');
        Route::get('/settings/menu/qr.svg', [SettingsController::class, 'qrSvg'])->name('settings.menu.qr');
    });

    Route::middleware('super.admin')->prefix('owner')->name('owner.')->group(function (): void {
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
        Route::patch('/restaurants/{restaurant}/subscription', [SuperAdminController::class, 'updateSubscription'])->name('restaurants.subscription.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');

require __DIR__.'/auth.php';
