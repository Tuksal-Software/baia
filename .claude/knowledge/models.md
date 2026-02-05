# BAIA Models & Relationships

## Model Summary (18 Models)

| Model | Table | Primary Relations |
|-------|-------|-------------------|
| User | users | hasOne(Cart) |
| Product | products | belongsTo(Category), hasMany(Images, Specs, Features, Variants, Reviews) |
| Category | categories | hasMany(Product), parent/children (self-ref) |
| Cart | carts | belongsTo(User), hasMany(CartItem) |
| CartItem | cart_items | belongsTo(Cart, Product) |
| Order | orders | hasMany(OrderItem) |
| OrderItem | order_items | belongsTo(Order, Product) |
| Review | reviews | belongsTo(Product, User) |
| ProductImage | product_images | belongsTo(Product) |
| ProductFeature | product_features | belongsTo(Product) |
| ProductVariant | product_variants | belongsTo(Product) |
| ProductSpecification | product_specifications | belongsTo(Product) |
| DiscountCode | discount_codes | - |
| Banner | banners | - |
| Slider | sliders | - |
| HomeSection | home_sections | - |
| SiteSetting | site_settings | - |
| NewsletterSubscriber | newsletter_subscribers | - |
| Menu | menus | hasMany(MenuItem) |
| MenuItem | menu_items | belongsTo(Menu), parent/children (self-ref) |

---

## Detailed Model Definitions

### User
**Location**: `app/Models/User.php`
**Fillable**: name, email, password, is_admin

```php
// Relationships
hasOne(Cart::class)

// Methods
isAdmin(): bool  // Returns $this->is_admin
```

### Product
**Location**: `app/Models/Product.php`
**Fillable**: category_id, name, slug, description, price, sale_price, stock, is_active, is_featured, is_new, rating, reviews_count

```php
// Relationships
belongsTo(Category::class)
hasMany(ProductImage::class)
hasMany(ProductSpecification::class)
hasMany(ProductFeature::class)
hasMany(ProductVariant::class)
hasMany(Review::class)
hasOne(ProductImage::class)->where('is_primary', true)  // primaryImage
hasMany(Review::class)->where('is_approved', true)      // approvedReviews

// Scopes
scopeActive($query)    // is_active = true
scopeFeatured($query)  // is_featured = true
scopeNew($query)       // is_new = true
scopeOnSale($query)    // sale_price not null AND sale_price < price
scopeInStock($query)   // stock > 0

// Accessors
current_price     // sale_price ?? price
is_on_sale        // sale_price && sale_price < price
discount_percentage  // ((price - sale_price) / price) * 100
is_in_stock       // stock > 0

// Methods
updateRating()    // Recalculates rating from approved reviews
```

### Category
**Location**: `app/Models/Category.php`
**Fillable**: name, slug, description, parent_id, is_active

```php
// Relationships
hasMany(Product::class)
belongsTo(Category::class, 'parent_id')  // parent
hasMany(Category::class, 'parent_id')    // children
```

### Cart
**Location**: `app/Models/Cart.php`
**Fillable**: user_id, session_id

```php
// Relationships
belongsTo(User::class)
hasMany(CartItem::class)
```

### CartItem
**Location**: `app/Models/CartItem.php`
**Fillable**: cart_id, product_id, quantity, variant_id

```php
// Relationships
belongsTo(Cart::class)
belongsTo(Product::class)
```

### Order
**Location**: `app/Models/Order.php`
**Fillable**: order_number, user_id, status, total, subtotal, discount, shipping_fee, name, email, phone, address, city, district, postal_code, notes, discount_code_id

```php
// Relationships
hasMany(OrderItem::class)
belongsTo(DiscountCode::class)

// Status values: pending, confirmed, processing, shipped, delivered, cancelled
```

### OrderItem
**Location**: `app/Models/OrderItem.php`
**Fillable**: order_id, product_id, quantity, price, variant_info

```php
// Relationships
belongsTo(Order::class)
belongsTo(Product::class)
```

### Review
**Location**: `app/Models/Review.php`
**Fillable**: product_id, user_id, name, email, rating, comment, is_approved, is_verified

```php
// Relationships
belongsTo(Product::class)
belongsTo(User::class)
```

### ProductImage
**Location**: `app/Models/ProductImage.php`
**Fillable**: product_id, image_path, is_primary, sort_order

```php
// Relationships
belongsTo(Product::class)
```

### ProductVariant
**Location**: `app/Models/ProductVariant.php`
**Fillable**: product_id, name, type, value, price_modifier, stock

```php
// Relationships
belongsTo(Product::class)
// type: color, size, material, etc.
```

### DiscountCode
**Location**: `app/Models/DiscountCode.php`
**Fillable**: code, type, value, min_order_amount, max_uses, used_count, starts_at, expires_at, is_active

```php
// type: percentage, fixed
```

### Banner, Slider, HomeSection, SiteSetting
CMS entities for dynamic content management.

### Menu & MenuItem
Navigation management with hierarchical structure.

---

## Common Patterns

### Eager Loading
```php
Product::with(['category', 'primaryImage', 'approvedReviews'])->get();
Order::with('items.product')->get();
```

### Scoped Queries
```php
Product::active()->featured()->inStock()->get();
Product::onSale()->latest()->take(10)->get();
```
