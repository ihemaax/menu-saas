<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'logo_path',
        'banner_path',
        'description',
        'subscription_status',
        'subscription_starts_at',
        'subscription_ends_at',
    ];

    protected $casts = [
        'subscription_starts_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    public function menuSetting(): HasOne
    {
        return $this->hasOne(MenuSetting::class);
    }

    public function effectiveSubscriptionStatus(): string
    {
        if ($this->subscription_status === 'suspended') {
            return 'suspended';
        }

        if ($this->subscription_status === 'active' && $this->subscription_ends_at?->isPast()) {
            return 'expired';
        }

        return $this->subscription_status ?: 'expired';
    }

    public function isSubscriptionActive(): bool
    {
        return $this->effectiveSubscriptionStatus() === 'active';
    }

    public function isSubscriptionReadOnly(): bool
    {
        return in_array($this->effectiveSubscriptionStatus(), ['expired', 'suspended'], true);
    }

    public function subscriptionDaysRemaining(): ?int
    {
        if (! $this->isSubscriptionActive() || ! $this->subscription_ends_at) {
            return null;
        }

        return max(0, now()->startOfDay()->diffInDays($this->subscription_ends_at->startOfDay(), false));
    }
}
