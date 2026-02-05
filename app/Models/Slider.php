<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'image_mobile',
        'button_text',
        'button_link',
        'button_style',
        'text_position',
        'text_color',
        'overlay_color',
        'order',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return '';
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        // Handle both old (sliders/...) and new (uploads/sliders/...) path formats
        $path = str_starts_with($this->image, 'uploads/') ? $this->image : 'uploads/' . $this->image;
        return asset($path);
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        if (!$this->image_mobile) {
            return null;
        }
        if (str_starts_with($this->image_mobile, 'http')) {
            return $this->image_mobile;
        }
        // Handle both old and new path formats
        $path = str_starts_with($this->image_mobile, 'uploads/') ? $this->image_mobile : 'uploads/' . $this->image_mobile;
        return asset($path);
    }
}
