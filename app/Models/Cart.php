<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
    ];

    /**
     * Get the user (if logged in)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get cart items
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get total items count
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Get subtotal
     */
    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Add item to cart
     */
    public function addItem(Product $product, int $quantity = 1, ?ProductVariant $variant = null): CartItem
    {
        $existingItem = $this->items()
            ->where('product_id', $product->id)
            ->where('variant_id', $variant?->id)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
            return $existingItem;
        }

        $price = $variant ? $variant->final_price : $product->current_price;

        return $this->items()->create([
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
            'quantity' => $quantity,
            'price' => $price,
        ]);
    }

    /**
     * Update item quantity
     */
    public function updateItemQuantity(CartItem $item, int $quantity): void
    {
        if ($quantity <= 0) {
            $item->delete();
            return;
        }

        $item->quantity = $quantity;
        $item->save();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    /**
     * Clear cart
     */
    public function clear(): void
    {
        $this->items()->delete();
    }

    /**
     * Check if cart is empty
     */
    public function getIsEmptyAttribute(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * Get or create cart by session
     */
    public static function getBySession(string $sessionId, ?int $userId = null): self
    {
        $cart = self::where('session_id', $sessionId)->first();

        if (!$cart) {
            $cart = self::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
            ]);
        } elseif ($userId && !$cart->user_id) {
            $cart->user_id = $userId;
            $cart->save();
        }

        return $cart;
    }
}
