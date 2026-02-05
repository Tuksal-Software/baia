<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the cart
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get item total
     */
    public function getTotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get display name (product + variant)
     */
    public function getDisplayNameAttribute(): string
    {
        $name = $this->product->name;

        if ($this->variant) {
            $name .= ' - ' . $this->variant->name;
        }

        return $name;
    }

    /**
     * Check if item is still available
     */
    public function getIsAvailableAttribute(): bool
    {
        if (!$this->product->is_active) {
            return false;
        }

        if ($this->variant) {
            return $this->variant->is_active && $this->variant->stock >= $this->quantity;
        }

        return $this->product->stock >= $this->quantity;
    }

    /**
     * Update price from current product/variant price
     */
    public function refreshPrice(): void
    {
        $this->price = $this->variant
            ? $this->variant->final_price
            : $this->product->current_price;
        $this->save();
    }
}
