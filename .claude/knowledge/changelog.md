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

## [3.0.0] - 2026-02-05

### Multi-Language Support (Localization)

### Added
- **Laravel Localization System**: Full i18n support for 3 languages
  - Turkish (default), English, German
  - Session-based language switching
  - Browser language detection

- **SetLocale Middleware**: Automatic locale detection and setting
  - File: `app/Http/Middleware/SetLocale.php`
  - Registered in `bootstrap/app.php` for web middleware

- **Language Controller**: Handles language switching
  - File: `app/Http/Controllers/LanguageController.php`
  - Route: `GET /lang/{locale}` → `language.switch`

- **Translation Service**: MyMemory API integration for auto-translation
  - File: `app/Services/TranslationService.php`
  - Free API, no API key required
  - Supports TR → EN, TR → DE translations
  - 24-hour cache for translated strings

- **Admin Translation Controller**: AJAX endpoints for admin panel
  - File: `app/Http/Controllers/Admin/TranslationController.php`
  - Routes: `POST admin/translations/translate`, `POST admin/translations/translate-field`

- **Translatable Form Components** (Admin Panel)
  - `form-translatable-input.blade.php` - Input with language tabs
  - `form-translatable-textarea.blade.php` - Textarea with language tabs
  - Features: Language tabs (TR/EN/DE), Auto-translate button, Alpine.js powered

- **Language Switcher Component** (Frontend)
  - File: `resources/views/components/language-switcher.blade.php`
  - Dropdown with flags and language names
  - Mobile version in hamburger menu

- **Language Files**: JSON translation files
  - `lang/tr.json` - Turkish (100+ strings)
  - `lang/en.json` - English translations
  - `lang/de.json` - German translations

- **Database Migration**: Convert text fields to JSON for translations
  - File: `database/migrations/2026_02_05_000001_convert_translatable_fields_to_json.php`
  - Converts existing data to JSON format with Turkish as default

### Changed
- **Config**: `config/app.php`
  - Default locale set to 'tr'
  - Added `available_locales` array with language metadata (name, native, flag)

- **Models Updated with HasTranslations Trait**:
  - `Product.php` - translatable: name, short_description, description
  - `Category.php` - translatable: name, description
  - `Slider.php` - translatable: title, subtitle, description, button_text
  - `Banner.php` - translatable: title, subtitle
  - `HomeSection.php` - translatable: title, subtitle
  - `Feature.php` - translatable: title, description

- **Admin Controllers Updated**:
  - `ProductController.php` - Handles array input for translatable fields
  - `CategoryController.php` - Handles array input for translatable fields

- **Admin Forms Updated**:
  - `products/create.blade.php` - Uses translatable components
  - `products/edit.blade.php` - Uses translatable components
  - `categories/create.blade.php` - Uses translatable components
  - `categories/edit.blade.php` - Uses translatable components

- **Frontend Layout**: `layouts/app.blade.php`
  - Added language switcher in header
  - Dynamic `lang` attribute on HTML tag
  - Mobile language switcher in hamburger menu

### Dependencies
- Added `spatie/laravel-translatable: ^6.8` to composer.json
- Run `composer install` after pulling changes

### Technical Notes
- Hybrid translation approach: Auto-translate + manual correction
- MyMemory API: Free, 1000 words/day limit, cached 24 hours
- Backward compatible: Old text data auto-wrapped as Turkish translation
- No breaking changes to existing functionality

### Usage
1. Install dependencies: `composer install`
2. Run migration: `php artisan migrate`
3. Access language switcher in frontend header
4. Use "Auto Translate" button in admin forms to translate content

---

## [3.0.1] - 2026-02-05

### Localization Bugfix

### Fixed
- **Spatie Translatable Not Working**: Seeders were using `DB::table()` instead of Model classes
  - Root cause: `DB::table()->insert()` bypasses Eloquent, so `HasTranslations` trait never processed the data
  - Solution: Converted all seeders to use Model classes (`Category::create()`, `Product::create()`, etc.)
  - Removed `json_encode()` from seeders - Spatie handles JSON conversion automatically

- **Mega Navbar Shadow Bug**: Removed overlay div causing gray shadow when scrolling
  - File: `resources/views/components/mega-navbar.blade.php`
  - Removed overlay element that had `bg-black/10` class

### Changed
- **CategorySeeder.php**: Now uses `Category::create()` with array translations
- **ProductSeeder.php**: Now uses `Product::create()` with array translations
- **FeatureSeeder.php**: Now uses `Feature::create()` with array translations
- **HomeSectionSeeder.php**: Now uses `HomeSection::create()` with array translations

### Technical Notes
- **IMPORTANT**: When using `spatie/laravel-translatable`, ALWAYS use Eloquent Models for seeding/creating records
- `DB::table()->insert()` will NOT work with HasTranslations trait
- Translatable arrays should be passed as PHP arrays, NOT json_encode'd strings
- Example correct usage: `'name' => ['tr' => 'Koltuklar', 'en' => 'Armchairs', 'de' => 'Sessel']`

---

## [3.0.2] - 2026-02-05

### Menu & MenuItem Localization

### Added
- **Menu Model HasTranslations**: Added multi-language support to menus
  - File: `app/Models/Menu.php`
  - Added `HasTranslations` trait
  - Translatable field: `name`

- **MenuItem Model HasTranslations**: Added multi-language support to menu items
  - File: `app/Models/MenuItem.php`
  - Added `HasTranslations` trait
  - Translatable field: `title`

- **Database Migration**: Convert Menu/MenuItem fields to JSON
  - File: `database/migrations/2026_02_05_000002_convert_menu_items_title_to_json.php`
  - Converts `menu_items.title` varchar → JSON
  - Converts `menus.name` varchar → JSON
  - Migrates existing data with TR/EN/DE copies

### Changed
- **MenuSeeder.php**: Updated with translations for all menu items
  - Header menu items: Yeni Ürünler, Oturma Odası, etc. with EN/DE translations
  - Footer menu: Hakkımızda, İletişim, Kariyer, etc. with EN/DE translations
  - Footer secondary menu: Sipariş Takibi, Kargo & Teslimat, etc. with EN/DE translations

### Technical Notes
- Run `php artisan migrate:fresh --seed` to apply changes
- Menus now automatically display in current locale
- Footer and navbar menu items will change based on language selection

---

## [3.1.0] - 2026-02-05

### Complete Admin Panel Localization Audit

### Changed
- **Features Module**: Full localization
  - `features/index.blade.php` - All UI text uses `__()` helper
  - `features/create.blade.php` - Translatable inputs for title/description
  - `features/edit.blade.php` - Translatable inputs with `getTranslations()`
  - `FeatureController.php` - `getPositions()` and `getIcons()` methods return translated strings

- **Menus Module**: Full localization
  - `menus/index.blade.php` - All UI text uses `__()` helper
  - `menus/edit.blade.php` - All UI text + JS translations object
  - `MenuController.php` - Success message uses `__()` helper

- **Sliders Module**: Full localization
  - `sliders/index.blade.php` - All UI text uses `__()` helper
  - `sliders/create.blade.php` - Already localized (verified)
  - `sliders/edit.blade.php` - Already localized (verified)

- **Banners Module**: Full localization
  - `banners/index.blade.php` - All UI text uses `__()` helper
  - `banners/create.blade.php` - Already localized (verified)
  - `banners/edit.blade.php` - Already localized (verified)

- **Home Sections Module**: Full localization
  - `home-sections/index.blade.php` - All UI text uses `__()` helper
  - `home-sections/create.blade.php` - Already localized (verified)
  - `home-sections/edit.blade.php` - Already localized (verified)

### Added
- **Translation Strings**: 100+ new translation keys added to language files
  - `lang/tr.json` - Turkish translations
  - `lang/en.json` - English translations
  - `lang/de.json` - German translations
  - Categories: Features, Menus, Sliders, Banners, Home Sections, General UI

### Technical Notes
- All admin panel "İçerik Yönetimi" (Content Management) section views now fully localized
- All translatable database fields use `form-translatable-input` and `form-translatable-textarea` components
- JavaScript code in views uses a `translations` object for dynamic text
- FeatureController constants converted to methods to support runtime translation

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
- [x] Multi-language support (Localization)

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
