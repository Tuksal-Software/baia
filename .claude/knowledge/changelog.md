# BAIA Changelog

## Format
```
## [Version] - YYYY-MM-DD
### Added / Changed / Fixed / Removed
- Description of change
```

---

## [1.0.0] - 2026-02-05

### Initial Project Analysis
- Project structure analyzed and documented
- Knowledge base created:
  - `project-structure.md` - Overall architecture
  - `models.md` - 18 Eloquent models documented
  - `routes.md` - 100+ routes mapped
  - `database.md` - 24 tables documented
  - `services.md` - Business logic documented
  - `frontend.md` - View structure documented

### Existing Features (as found)
- **E-Commerce Core**
  - Product catalog with categories
  - Product variants (color, size, etc.)
  - Product images, specifications, features
  - Shopping cart (session/user based)
  - Checkout flow
  - Order management
  - Discount codes

- **User System**
  - Registration and login
  - Admin role (is_admin flag)
  - AdminMiddleware protection

- **CMS**
  - Homepage sliders
  - Promotional banners
  - Dynamic home sections
  - Navigation menus
  - Site settings

- **Admin Panel**
  - Dashboard
  - Product CRUD with bulk actions
  - Category management
  - Order management with export
  - Review approval system
  - Discount code management
  - CMS content management
  - Newsletter subscribers

### Technical Stack
- Laravel 12.0
- PHP 8.2+
- Tailwind CSS 4.0
- Vite 7.0.7
- SQLite (default)
- PHPUnit 11.5.3

---

## Pending / Future Changes

_Bu bölüm yeni değişiklikler yapıldıkça güncellenecek._

### Planned Improvements
- [ ] Service layer refactoring
- [ ] Event/Listener implementation
- [ ] Test coverage improvement
- [ ] API endpoints (Sanctum)
- [ ] Payment gateway integration
- [ ] Email notifications

---

## How to Update This File

Her değişiklikten sonra:

1. Yeni bir tarih bloğu ekle
2. Değişiklik tipini belirt (Added/Changed/Fixed/Removed)
3. Kısa açıklama yaz
4. İlgili dosyaları listele

Örnek:
```
## [1.0.1] - 2026-02-06

### Added
- Password reset feature
  - Migration: create_password_resets_table
  - Model: PasswordReset
  - Controller: Auth\ForgotPasswordController
  - Views: auth/passwords/email.blade.php, reset.blade.php
  - Routes: /sifremi-unuttum, /sifre-sifirla/{token}

### Changed
- User model: Added password_reset_token field
```
