# BAIA Routes

## Route Overview

| Group | Prefix | Middleware | Count |
|-------|--------|------------|-------|
| Public | / | web | ~25 |
| Auth | / | web, guest | 6 |
| Admin | /admin | web, auth, admin | ~70 |

---

## Public Routes (Frontend)

### Homepage & Static
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | / | HomeController@index | home |
| GET | /hakkimizda | HomeController@about | about |
| GET | /iletisim | HomeController@contact | contact |
| POST | /iletisim | HomeController@sendContact | contact.send |
| GET | /arama | HomeController@search | search |

### Products
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /urunler | ProductController@index | products.index |
| GET | /urun/{slug} | ProductController@show | products.show |
| GET | /one-cikan-urunler | ProductController@featured | products.featured |
| GET | /yeni-urunler | ProductController@new | products.new |
| GET | /indirimli-urunler | ProductController@sale | products.sale |

### Categories
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /kategoriler | CategoryController@index | categories.index |
| GET | /kategori/{slug} | CategoryController@show | categories.show |

### Cart
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /sepet | CartController@index | cart.index |
| POST | /sepet/ekle | CartController@add | cart.add |
| PATCH | /sepet/guncelle/{id} | CartController@update | cart.update |
| DELETE | /sepet/sil/{id} | CartController@remove | cart.remove |
| DELETE | /sepet/temizle | CartController@clear | cart.clear |
| POST | /sepet/indirim-kodu | CartController@applyDiscount | cart.apply-discount |
| DELETE | /sepet/indirim-kodu | CartController@removeDiscount | cart.remove-discount |

### Checkout
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /siparis | CheckoutController@index | checkout.index |
| POST | /siparis | CheckoutController@store | checkout.store |
| GET | /siparis/onay/{orderNumber} | CheckoutController@confirmation | checkout.confirmation |
| GET | /siparis/takip | CheckoutController@track | checkout.track |
| POST | /siparis/takip | CheckoutController@trackOrder | checkout.track.submit |

### Reviews
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| POST | /urun/{product}/yorum | ReviewController@store | reviews.store |

### Newsletter
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| POST | /newsletter/subscribe | NewsletterController@subscribe | newsletter.subscribe |

---

## Auth Routes

| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /giris | LoginController@showLoginForm | login |
| POST | /giris | LoginController@login | login.submit |
| POST | /cikis | LoginController@logout | logout |
| GET | /kayit | RegisterController@showRegistrationForm | register |
| POST | /kayit | RegisterController@register | register.submit |

---

## Admin Routes (Prefix: /admin)

**Middleware**: web, auth, admin

### Dashboard
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | / | DashboardController@index | admin.dashboard |

### Products (Resource + Custom)
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /products | ProductController@index | admin.products.index |
| GET | /products/create | ProductController@create | admin.products.create |
| POST | /products | ProductController@store | admin.products.store |
| GET | /products/{id} | ProductController@show | admin.products.show |
| GET | /products/{id}/edit | ProductController@edit | admin.products.edit |
| PUT | /products/{id} | ProductController@update | admin.products.update |
| DELETE | /products/{id} | ProductController@destroy | admin.products.destroy |
| POST | /products/bulk-action | ProductController@bulkAction | admin.products.bulk-action |
| PATCH | /products/{id}/toggle-status | ProductController@toggleStatus | admin.products.toggle-status |
| PATCH | /products/{id}/toggle-featured | ProductController@toggleFeatured | admin.products.toggle-featured |

### Categories (Resource)
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| * | /categories | CategoryController (resource) | admin.categories.* |

### Orders
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /orders | OrderController@index | admin.orders.index |
| GET | /orders/{id} | OrderController@show | admin.orders.show |
| PATCH | /orders/{id}/status | OrderController@updateStatus | admin.orders.update-status |
| POST | /orders/{id}/note | OrderController@addNote | admin.orders.add-note |
| PATCH | /orders/{id}/confirm | OrderController@confirm | admin.orders.confirm |
| GET | /orders/export | OrderController@export | admin.orders.export |

### Reviews
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /reviews | ReviewController@index | admin.reviews.index |
| GET | /reviews/{id} | ReviewController@show | admin.reviews.show |
| PATCH | /reviews/{id}/approve | ReviewController@approve | admin.reviews.approve |
| PATCH | /reviews/{id}/reject | ReviewController@reject | admin.reviews.reject |
| PATCH | /reviews/{id}/verify | ReviewController@verify | admin.reviews.verify |
| DELETE | /reviews/{id} | ReviewController@destroy | admin.reviews.destroy |

### Discount Codes (Resource)
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| * | /discount-codes | DiscountCodeController (resource) | admin.discount-codes.* |

### CMS - Sliders, Banners, HomeSections, Features
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| * | /sliders | SliderController (resource) | admin.sliders.* |
| POST | /sliders/order | SliderController@updateOrder | admin.sliders.order |
| * | /banners | BannerController (resource) | admin.banners.* |
| POST | /banners/order | BannerController@updateOrder | admin.banners.order |
| * | /home-sections | HomeSectionController (resource) | admin.home-sections.* |
| POST | /home-sections/order | HomeSectionController@updateOrder | admin.home-sections.order |
| * | /features | FeatureController (resource) | admin.features.* |

### Settings
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /settings | SettingController@index | admin.settings.index |
| POST | /settings | SettingController@update | admin.settings.update |

### Menus
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /menus | MenuController@index | admin.menus.index |
| GET | /menus/{id}/edit | MenuController@edit | admin.menus.edit |
| PUT | /menus/{id} | MenuController@update | admin.menus.update |
| POST | /menus/{id}/items | MenuController@addItem | admin.menus.add-item |
| DELETE | /menus/items/{id} | MenuController@removeItem | admin.menus.remove-item |
| POST | /menus/{id}/items/order | MenuController@updateItemOrder | admin.menus.update-item-order |

### Newsletter
| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | /newsletter | NewsletterController@index | admin.newsletter.index |
| DELETE | /newsletter/{id} | NewsletterController@destroy | admin.newsletter.destroy |
| GET | /newsletter/export | NewsletterController@export | admin.newsletter.export |

---

## Named Route Examples

```php
// Frontend
route('home')                           // /
route('products.show', $product->slug)  // /urun/{slug}
route('cart.add')                       // POST /sepet/ekle
route('checkout.index')                 // /siparis

// Admin
route('admin.dashboard')                // /admin
route('admin.products.index')           // /admin/products
route('admin.orders.show', $id)         // /admin/orders/{id}
```
