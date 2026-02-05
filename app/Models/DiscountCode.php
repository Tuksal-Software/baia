<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_FIXED = 'fixed';

    /**
     * Check if code is valid
     */
    public function isValid(float $orderAmount = 0): bool
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check date range
        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // Check minimum order amount
        if ($orderAmount > 0 && $orderAmount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $orderAmount): float
    {
        if (!$this->isValid($orderAmount)) {
            return 0;
        }

        if ($this->type === self::TYPE_PERCENTAGE) {
            return round($orderAmount * ($this->value / 100), 2);
        }

        // Fixed discount
        return min($this->value, $orderAmount);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->used_count++;
        $this->save();
    }

    /**
     * Get validation error message
     */
    public function getValidationError(float $orderAmount = 0): ?string
    {
        if (!$this->is_active) {
            return 'Bu indirim kodu aktif değil.';
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return 'Bu indirim kodu henüz başlamadı.';
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return 'Bu indirim kodunun süresi dolmuş.';
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'Bu indirim kodu kullanım limitine ulaşmış.';
        }

        if ($orderAmount > 0 && $orderAmount < $this->min_order_amount) {
            return "Bu indirim kodu için minimum sipariş tutarı " . number_format($this->min_order_amount, 2) . " TL.";
        }

        return null;
    }

    /**
     * Get formatted value
     */
    public function getFormattedValueAttribute(): string
    {
        if ($this->type === self::TYPE_PERCENTAGE) {
            return '%' . intval($this->value);
        }

        return number_format($this->value, 2) . ' TL';
    }

    /**
     * Scope for active codes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for valid codes (date check)
     */
    public function scopeValid($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')->orWhereRaw('used_count < usage_limit');
            });
    }

    /**
     * Find by code
     */
    public static function findByCode(string $code): ?self
    {
        return self::where('code', strtoupper($code))->first();
    }
}
