<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'order',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'is_primary' => 'boolean',
        ];
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Set this image as primary
     */
    public function setAsPrimary(): void
    {
        // Remove primary from other images
        $this->product->images()->where('id', '!=', $this->id)->update(['is_primary' => false]);

        // Set this as primary
        $this->is_primary = true;
        $this->save();
    }

    /**
     * Scope for primary images
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get image URL with proper path handling
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image_path) {
            return '';
        }
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        // Handle both old (products/...) and new (uploads/products/...) path formats
        $path = str_starts_with($this->image_path, 'uploads/') ? $this->image_path : 'uploads/' . $this->image_path;
        return asset($path);
    }
}
