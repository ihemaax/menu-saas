<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'menu_setting_id',
        'visited_on',
        'visited_at',
        'visitor_hash',
        'ip_hash',
        'user_agent_hash',
        'device_type',
        'source',
        'path',
        'referer',
    ];

    protected $casts = [
        'visited_on' => 'date',
        'visited_at' => 'datetime',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function menuSetting(): BelongsTo
    {
        return $this->belongsTo(MenuSetting::class);
    }
}
