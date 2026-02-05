<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price_difference',
        'image',
        'stock',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_difference' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
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
     * Get final price (product price + difference)
     */
    public function getFinalPriceAttribute(): float
    {
        $basePrice = $this->product->current_price;
        return $basePrice + $this->price_difference;
    }

    /**
     * Check if variant is in stock
     */
    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Scope for active variants
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for in-stock variants
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
