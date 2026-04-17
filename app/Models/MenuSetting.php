<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'slug',
        'is_public',
        'active_theme',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
