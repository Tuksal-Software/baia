<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];

    /**
     * Get menu items
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    /**
     * Get root menu items (no parent)
     */
    public function rootItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->orderBy('order');
    }

    /**
     * Get menu by location with caching
     */
    public static function getByLocation(string $location): ?self
    {
        return Cache::remember("menu_{$location}", 3600, function () use ($location) {
            return static::where('location', $location)
                ->with(['rootItems.children' => function ($query) {
                    $query->where('is_active', true)->orderBy('order');
                }])
                ->first();
        });
    }

    /**
     * Clear menu cache
     */
    public static function clearCache(): void
    {
        Cache::forget('menu_header');
        Cache::forget('menu_footer');
        Cache::forget('menu_footer_secondary');
    }
}
