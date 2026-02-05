<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeSection extends Model
{
    use HasTranslations;

    /**
     * Translatable fields
     */
    public array $translatable = ['title', 'subtitle'];
    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'settings',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Available section types
     */
    public const TYPES = [
        'slider' => 'Hero Slider',
        'categories' => 'Kategori Kartları',
        'products' => 'Ürün Carousel',
        'banner' => 'Banner',
        'features' => 'Özellikler Barı',
        'newsletter' => 'Bülten Aboneliği',
    ];

    /**
     * Scope for active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get setting value
     */
    public function getSetting(string $key, mixed $default = null): mixed
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
