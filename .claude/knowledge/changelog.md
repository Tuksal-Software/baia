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

## [1.1.0] - 2026-02-05

### Tikamoon-Inspired UI Redesign

### Fixed
- **Storage Link Issue**: Added route-based storage file serving as symlink alternative
  - File: `routes/web.php` - Added `/storage/{path}` route
  - Allows images to display without requiring `php artisan storage:link`

### Changed
- **CSS Theme System**: Complete redesign with Tikamoon-inspired palette
  - File: `resources/css/app.css`
  - New color palette: black, white, beige (#EDE4D3), warm-gray
  - Typography: Playfair Display (serif) + Inter (sans-serif)
  - New component classes: `.btn`, `.product-card`, `.category-card`, `.section-title`
  - New utility classes: `.hover-lift`, `.img-zoom`, `.scroll-snap-x`

- **Hero Slider**: Complete redesign
  - File: `resources/views/components/hero-slider.blade.php`
  - Full viewport height (85vh on desktop)
  - Ken Burns effect on images
  - Elegant progress bar navigation
  - Slide counter (01/03 format)
  - Scroll indicator
  - Keyboard navigation support
  - Pause on hover

- **Product Card**: Modern minimal design
  - File: `resources/views/components/product-card.blade.php`
  - 3:4 aspect ratio images
  - Hover zoom effect
  - Quick add button on hover (slide up animation)
  - Minimal badge design
  - Serif font for product names

- **Product Card Minimal**: Carousel variant updated
  - File: `resources/views/components/product-card-minimal.blade.php`
  - Secondary image swap on hover
  - Consistent styling with main product card

### Technical Notes
- All components use Alpine.js for interactivity
- Animations use CSS transitions (no JS animation libraries)
- Mobile responsive with touch support

---

## [1.2.0] - 2026-02-05

### File Upload System Overhaul

### Changed
- **File Upload Location**: Migrated from `storage/app/public` to `public/uploads`
  - More reliable, no symlink required
  - Direct public access to uploaded files

- **HandlesFileUploads Trait**: Created centralized file handling
  - File: `app/Traits/HandlesFileUploads.php`
  - Methods: `uploadFile()`, `deleteFile()`
  - Used by all admin controllers

- **Admin Controllers Updated**:
  - `SliderController.php` - uploads to `public/uploads/sliders`
  - `BannerController.php` - uploads to `public/uploads/banners`
  - `CategoryController.php` - uploads to `public/uploads/categories`
  - `ProductController.php` - uploads to `public/uploads/products`
  - `SettingController.php` - uploads to `public/uploads/settings`

### Added
- **ImageHelper**: Global helper function for image URLs
  - File: `app/Helpers/ImageHelper.php`
  - Function: `image_url($path, $type)` - handles both old and new path formats
  - Registered in `composer.json` autoload

- **Model Image URL Accessors**: Added to all models with images
  - `Slider::getImageUrlAttribute()`, `getMobileImageUrlAttribute()`
  - `Banner::getImageUrlAttribute()`, `getMobileImageUrlAttribute()`
  - `Category::getImageUrlAttribute()`
  - `ProductImage::getImageUrlAttribute()`
  - All handle both old (e.g., `sliders/img.jpg`) and new (e.g., `uploads/sliders/img.jpg`) path formats

### Fixed
- **Homepage Slider Images**: Now display correctly
- **All Image References**: Updated 15+ view files to use accessor methods
  - Views using `asset('storage/' . ...)` changed to use model accessors
  - Admin views updated to use `$model->image_url` instead of `asset($model->image)`
  - Settings views use `image_url()` helper

### Files Modified
**Models:**
- `app/Models/Slider.php`
- `app/Models/Banner.php`
- `app/Models/Category.php`
- `app/Models/ProductImage.php`

**Views:**
- `layouts/app.blade.php`
- `admin/categories/index.blade.php`
- `admin/categories/edit.blade.php`
- `admin/settings/index.blade.php`
- `admin/products/index.blade.php`
- `admin/products/edit.blade.php`
- `admin/products/show.blade.php`
- `categories/index.blade.php`
- `products/show.blade.php`
- `cart/index.blade.php`
- `components/category-cards.blade.php`
- `components/product-card.blade.php`
- `components/product-card-minimal.blade.php`

### Technical Notes
- Backwards compatible: Models auto-prepend `uploads/` to old path formats
- No database migration required
- Run `composer dump-autoload` after pulling changes

---

## [1.3.0] - 2026-02-05

### Tikamoon-Style Mega Navbar

### Added
- **Mega Navbar Component**: Full-width dropdown navigation
  - File: `resources/views/components/mega-navbar.blade.php`
  - Dynamic category-based navigation
  - Hover-triggered mega dropdowns
  - Subcategories displayed in grid layout
  - Category images in mega menu
  - Smooth transitions and animations
  - Alpine.js powered interactions

- **Navigation Categories**: ViewServiceProvider updated
  - File: `app/Providers/ViewServiceProvider.php`
  - `$navCategories` shared globally with all views
  - Cached for performance (1 hour TTL)
  - Includes nested children (3 levels deep)

- **Category Cache Clearing**: Automatic navbar updates
  - File: `app/Models/Category.php`
  - Cache clears on category save/delete
  - Ensures navbar reflects current categories

### Changed
- **Layout Header**: Restructured for mega navbar
  - File: `resources/views/layouts/app.blade.php`
  - Top bar: Logo, search, account, cart
  - Below: Full-width mega navigation bar
  - Removed old inline desktop navigation

- **Mobile Menu**: Updated with categories
  - Shows all root categories with expandable subcategories
  - Additional menu items shown below categories
  - Consistent with desktop mega navbar

### Features
- Hover to open mega menu (desktop)
- Click to expand categories (mobile)
- Category images displayed in mega dropdown
- "View All" links for each category
- Smooth open/close animations
- Mouse-friendly with close timer
- Overlay background when menu open

### Files Modified
- `app/Models/Category.php` - Cache clearing
- `app/Providers/ViewServiceProvider.php` - NavCategories
- `resources/views/layouts/app.blade.php` - New navbar integration
- `resources/views/components/mega-navbar.blade.php` - New component

---

## [1.3.1] - 2026-02-05

### Mega Navbar Hover Bug Fix

### Fixed
- **Hover Gap Bug**: Fixed menu flickering when mouse moves between nav item and dropdown
  - File: `resources/views/components/mega-navbar.blade.php`
  - Root cause: Dropdown was in separate container, creating gap
  - Solution: Moved dropdown inside each `<li>` element for seamless hover
  - Increased close timer from 150ms to 200ms for smoother UX
  - Changed image group class to `group/img` to avoid parent conflict

### Technical Notes
- Dropdown now uses `top-full` positioning (directly below nav item)
- No gap between trigger and dropdown = no flicker
- Full-width dropdown still works with `w-screen` and centering

---

## [2.0.0] - 2026-02-05

### Admin Panel Complete Redesign

### Added
- **Modern Minimal Design System** (Stripe/Linear inspired)
  - New color palette: Indigo primary (#4F46E5), Slate backgrounds
  - Inter font family (Google Fonts)
  - Consistent spacing and typography

- **Admin Component Library** (`resources/views/components/admin/`)
  - `sidebar.blade.php` - Collapsible sidebar (64px collapsed, 256px expanded)
  - `sidebar-nav.blade.php` - Navigation menu with groups
  - `header.blade.php` - Top header with breadcrumbs and user menu
  - `button.blade.php` - Button variants (primary, secondary, success, danger, ghost, outline)
  - `badge.blade.php` - Status badges with dot indicator
  - `alert.blade.php` - Flash message alerts (success, warning, danger, info)
  - `modal.blade.php` - Modal dialog component
  - `card.blade.php` - Card container with header and footer
  - `stats-card.blade.php` - Dashboard statistic cards
  - `empty-state.blade.php` - Empty data state with action
  - `data-table.blade.php` - Data table with headers and pagination
  - `form-input.blade.php` - Text input with icon and validation
  - `form-select.blade.php` - Select dropdown with option groups
  - `form-textarea.blade.php` - Multi-line text input
  - `form-toggle.blade.php` - Toggle switch (on/off)
  - `form-checkbox.blade.php` - Checkbox input
  - `form-image.blade.php` - Image upload with preview

- **User Management Module** (NEW)
  - Controller: `app/Http/Controllers/Admin/UserController.php`
  - Views: `resources/views/admin/users/` (index, create, edit, show)
  - Routes: CRUD + toggle-admin
  - Features: Search, filter by role, admin toggle, prevent self-deletion

### Changed
- **Admin Layout** (`resources/views/layouts/admin.blade.php`)
  - Complete rewrite with new design system
  - Responsive collapsible sidebar
  - Mobile sidebar overlay
  - Toast notification system
  - Tailwind CSS custom configuration

- **Dashboard** (`resources/views/admin/dashboard.blade.php`)
  - Stats cards with icons and trends
  - Recent orders list with status badges
  - Low stock products warning
  - Quick actions grid
  - Order status overview

- **Products Module** - All views redesigned
  - `index.blade.php` - Table with filters, badges, quick actions
  - `create.blade.php` - Multi-section form with components
  - `edit.blade.php` - Image gallery management, variant editor
  - `show.blade.php` - Product detail view with all info

- **Categories Module** - All views redesigned
  - `index.blade.php` - Table with parent category, product count
  - `create.blade.php` - Form with image upload
  - `edit.blade.php` - Edit form with info card

- **Orders Module** - All views redesigned
  - `index.blade.php` - Table with status tabs, filters, inline status dropdown
  - `show.blade.php` - Order detail with items, customer info, timeline, notes

- **Reviews Module** - All views redesigned
  - `index.blade.php` - Table with status tabs, star ratings, action buttons
  - `show.blade.php` - Review detail with rating, product info, customer info
- **Discount Codes Module** - All views redesigned
  - `index.blade.php` - Table with status badges, pagination, empty state
  - `create.blade.php` - Form with code generator, validation hints
  - `edit.blade.php` - Edit form with usage info card
  - `show.blade.php` - Detail view with usage statistics, progress bar, quick actions
- **CMS Modules** - All views redesigned
  - Sliders: index, create, edit
  - Banners: index, create, edit
  - Home Sections: index, create, edit
  - Features: index, create, edit
  - Menus: index, edit
- **Settings Page** (`resources/views/admin/settings/index.blade.php`)
  - Grouped settings with icon tabs (Site, Contact, Social, SEO, Payment, Shipping)
  - Form inputs using admin component library
  - Support for all setting types: text, textarea, boolean, select, color, image, number, email, url, tel
  - Interactive color picker with preview
  - Image upload with remove functionality
  - Empty state for groups without settings

- **Newsletter Page** (`resources/views/admin/newsletter/index.blade.php`)
  - Stats cards showing total, active, and inactive subscribers
  - Filter form with search and status dropdown
  - Data table with selectable rows
  - Badge indicators for status (clickable to toggle)
  - Bulk delete functionality
  - Pagination with subscriber count

### Routes Updated
- Added user management routes to `routes/web.php`
  - `Route::resource('users', AdminUserController::class)`
  - `Route::patch('users/{user}/toggle-admin', ...)`

### Technical Notes
- LocalStorage sidebar state persistence
- Alpine.js powered interactions
- Responsive design (mobile-first)
- Consistent component API across all forms
- Toast notifications for feedback

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
