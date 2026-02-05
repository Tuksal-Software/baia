# BAIA Services & Business Logic

## Service Layer Overview

Bu projede şu anda ayrı Service veya Action sınıfları bulunmuyor. Business logic controller'lar içinde yer alıyor.

---

## Controller-Based Business Logic

### Cart Logic (CartController)

```php
// Sepete ekleme
add(Request $request)
- Product'ı bul
- Cart'ı bul veya oluştur (user_id veya session_id ile)
- CartItem ekle veya quantity güncelle
- Variant bilgisini kaydet

// Sepet güncelleme
update(Request $request, $id)
- CartItem quantity güncelle
- Stock kontrolü yap

// İndirim kodu uygulama
applyDiscount(Request $request)
- Kodu doğrula
- Min order amount kontrolü
- Aktiflik ve tarih kontrolü
- Session'a kaydet
```

### Checkout Logic (CheckoutController)

```php
store(Request $request)
- Adres validasyonu
- Order oluştur
- OrderItem'ları oluştur
- DiscountCode kullanım sayısını artır
- Cart'ı temizle
- Stock düşür
- Confirmation page'e yönlendir
```

### Review Logic (ReviewController)

```php
store(Request $request, Product $product)
- Rating ve comment validasyonu
- Review oluştur (is_approved = false default)
- Admin onayı bekle

// Admin tarafı
approve($id)
- is_approved = true
- Product rating güncelle

reject($id)
- Review sil veya is_approved = false
```

### Product Logic (Admin\ProductController)

```php
store(Request $request)
- Product validasyonu
- Slug oluştur
- Product kaydet
- ProductImage'ları kaydet (primary işaretle)
- ProductVariant'ları kaydet
- ProductSpecification'ları kaydet
- ProductFeature'ları kaydet

bulkAction(Request $request)
- Seçili ürünlerde toplu işlem
- activate, deactivate, delete, feature, unfeature

toggleStatus($id)
- is_active toggle

toggleFeatured($id)
- is_featured toggle
```

### Order Logic (Admin\OrderController)

```php
updateStatus(Request $request, $id)
- Status değiştir
- Status history (opsiyonel)

confirm($id)
- pending -> confirmed

export()
- CSV export
```

---

## Helper Methods in Models

### Product Model Helpers

```php
// Rating hesaplama
updateRating()
{
    $this->rating = $this->approvedReviews()->avg('rating') ?? 0;
    $this->reviews_count = $this->approvedReviews()->count();
    $this->save();
}

// Fiyat accessor'ları
getCurrentPriceAttribute()
{
    return $this->sale_price ?? $this->price;
}

getIsOnSaleAttribute()
{
    return $this->sale_price && $this->sale_price < $this->price;
}

getDiscountPercentageAttribute()
{
    if (!$this->is_on_sale) return 0;
    return round((($this->price - $this->sale_price) / $this->price) * 100);
}
```

### Cart Session Helper

```php
// CartController içinde
protected function getCart()
{
    if (auth()->check()) {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    $sessionId = session()->getId();
    return Cart::firstOrCreate(['session_id' => $sessionId]);
}
```

---

## Önerilen Service Layer Yapısı

Proje büyüdükçe şu service'ler oluşturulabilir:

```
app/Services/
├── CartService.php          # Cart operations
├── CheckoutService.php      # Order creation
├── DiscountService.php      # Discount validation
├── ProductService.php       # Product CRUD
├── ReviewService.php        # Review management
├── OrderService.php         # Order management
└── ImageService.php         # Image upload/resize
```

### Örnek CartService

```php
class CartService
{
    public function getOrCreateCart(): Cart
    public function addItem(Product $product, int $quantity, ?ProductVariant $variant): CartItem
    public function updateQuantity(CartItem $item, int $quantity): CartItem
    public function removeItem(CartItem $item): void
    public function clear(Cart $cart): void
    public function calculateTotal(Cart $cart): array
    public function applyDiscount(Cart $cart, string $code): DiscountResult
}
```

---

## Events & Listeners (Önerilen)

```
app/Events/
├── OrderPlaced.php
├── OrderStatusChanged.php
├── ReviewApproved.php
└── ProductStockLow.php

app/Listeners/
├── SendOrderConfirmation.php
├── UpdateProductRating.php
├── NotifyAdminLowStock.php
└── SendReviewApprovedNotification.php
```

---

## Mevcut ViewServiceProvider

```php
// app/Providers/ViewServiceProvider.php
// View composer'lar için

View::composer('*', function ($view) {
    // Global view data
    $view->with('categories', Category::active()->get());
    $view->with('settings', SiteSetting::all()->pluck('value', 'key'));
});
```
