<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Feature extends Model
{
    use HasTranslations;

    /**
     * Translatable fields
     */
    public array $translatable = ['title', 'description'];
    protected $fillable = [
        'icon',
        'title',
        'description',
        'link',
        'position',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Scope for active features
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for position
     */
    public function scopePosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Scope ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
