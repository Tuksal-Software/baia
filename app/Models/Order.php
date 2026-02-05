<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'subtotal',
        'discount',
        'discount_code',
        'total',
        'status',
        'notes',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'confirmed_at' => 'datetime',
        ];
    }

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get order items
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));

        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Create order from cart
     */
    public static function createFromCart(Cart $cart, array $customerData, ?DiscountCode $discountCode = null): self
    {
        $subtotal = $cart->subtotal;
        $discount = 0;

        if ($discountCode) {
            $discount = $discountCode->calculateDiscount($subtotal);
        }

        $order = self::create([
            'order_number' => self::generateOrderNumber(),
            'customer_name' => $customerData['name'],
            'customer_email' => $customerData['email'],
            'customer_phone' => $customerData['phone'],
            'customer_address' => $customerData['address'] ?? null,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'discount_code' => $discountCode?->code,
            'total' => $subtotal - $discount,
            'notes' => $customerData['notes'] ?? null,
        ]);

        // Create order items
        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'variant_id' => $cartItem->variant_id,
                'product_name' => $cartItem->product->name,
                'variant_name' => $cartItem->variant?->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'total' => $cartItem->total,
            ]);
        }

        // Increment discount code usage
        if ($discountCode) {
            $discountCode->incrementUsage();
        }

        // Clear cart
        $cart->clear();

        return $order;
    }

    /**
     * Confirm order
     */
    public function confirm(): void
    {
        $this->status = self::STATUS_CONFIRMED;
        $this->confirmed_at = now();
        $this->save();
    }

    /**
     * Cancel order
     */
    public function cancel(): void
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }

    /**
     * Update status
     */
    public function updateStatus(string $status): void
    {
        $this->status = $status;
        $this->save();
    }

    /**
     * Get WhatsApp message
     */
    public function getWhatsAppMessage(): string
    {
        $message = "🛒 *Yeni Sipariş: {$this->order_number}*\n\n";
        $message .= "👤 *Müşteri:* {$this->customer_name}\n";
        $message .= "📧 *E-posta:* {$this->customer_email}\n";
        $message .= "📱 *Telefon:* {$this->customer_phone}\n";

        if ($this->customer_address) {
            $message .= "📍 *Adres:* {$this->customer_address}\n";
        }

        $message .= "\n*Ürünler:*\n";
        foreach ($this->items as $item) {
            $itemName = $item->product_name;
            if ($item->variant_name) {
                $itemName .= " ({$item->variant_name})";
            }
            $message .= "• {$itemName} x{$item->quantity} = " . number_format($item->total, 2) . " TL\n";
        }

        $message .= "\n💰 *Ara Toplam:* " . number_format($this->subtotal, 2) . " TL\n";

        if ($this->discount > 0) {
            $message .= "🏷️ *İndirim ({$this->discount_code}):* -" . number_format($this->discount, 2) . " TL\n";
        }

        $message .= "💵 *Toplam:* " . number_format($this->total, 2) . " TL\n";

        if ($this->notes) {
            $message .= "\n📝 *Not:* {$this->notes}";
        }

        return $message;
    }

    /**
     * Get WhatsApp URL
     */
    public function getWhatsAppUrl(string $phoneNumber): string
    {
        $message = urlencode($this->getWhatsAppMessage());
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);

        return "https://wa.me/{$phone}?text={$message}";
    }

    /**
     * Scope by status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Beklemede',
            self::STATUS_CONFIRMED => 'Onaylandı',
            self::STATUS_PROCESSING => 'Hazırlanıyor',
            self::STATUS_SHIPPED => 'Kargoya Verildi',
            self::STATUS_DELIVERED => 'Teslim Edildi',
            self::STATUS_CANCELLED => 'İptal Edildi',
            default => $this->status,
        };
    }

    /**
     * Get status color (for UI)
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_CONFIRMED => 'blue',
            self::STATUS_PROCESSING => 'indigo',
            self::STATUS_SHIPPED => 'purple',
            self::STATUS_DELIVERED => 'green',
            self::STATUS_CANCELLED => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status badge class (full Tailwind class for CDN compatibility)
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-700',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-700',
            self::STATUS_PROCESSING => 'bg-indigo-100 text-indigo-700',
            self::STATUS_SHIPPED => 'bg-purple-100 text-purple-700',
            self::STATUS_DELIVERED => 'bg-green-100 text-green-700',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
