# BAIA Project Memory

## Critical Rules (User Preferences)
- **"Tek tek söyletme bana"** - Bir sorun varsa tüm ilgili dosyaları tarayıp hepsini bir seferde düzelt
- Kullanıcıya her adımda onay sorma, sorunları kendi başına çöz ve sonucu raporla
- Önemli öğrenimleri bu dosyaya kaydet

## YAPMAMAM GEREKEN HATALAR

### 1. Blade Component Attribute'larında `&` Kullanma
**YANLIŞ:**
```blade
<x-admin.card title="{{ __('Price & Stock') }}">
```
Sonuç: `Fiyat &amp; Stok` (çirkin!)

**DOĞRU:**
```blade
<x-admin.card title="{{ __('Price and Stock') }}">
{{-- veya --}}
<x-admin.card :title="__('Price & Stock')">
```
`:title` ile bind edince encode olmaz.

### 2. Category Select'te flatMap Kullanma
**YANLIŞ:**
```blade
:options="$categories->flatMap(function($cat) { ... })->toArray()"
```
Integer key'ler kaybolabilir, validation hatası verir.

**DOĞRU:**
```blade
@php
    $categoryOptions = [];
    foreach($categories as $cat) {
        $categoryOptions[$cat->id] = $cat->name;
    }
@endphp
:options="$categoryOptions"
```
Explicit foreach ile key'ler korunur.

### 3. Toggle Component'te Boş String Gönderme
**YANLIŞ:**
```blade
$refs.input.value = checked ? '1' : ''
```
Laravel `boolean` validation boş string'i reddeder.

**DOĞRU:**
```blade
$refs.input.value = checked ? '1' : '0'
```
Ve controller'da `'is_featured' => 'nullable'` kullan.

### 4. Spatie Translatable ile DB::table() Kullanma
**YANLIŞ:**
```php
DB::table('categories')->insert([
    'name' => json_encode(['tr' => 'Test']),
]);
```

**DOĞRU:**
```php
Category::create([
    'name' => ['tr' => 'Test', 'en' => 'Test'],
]);
```
Seeder'larda MUTLAKA Model sınıfı kullan, `DB::table()` değil!

---

## Spatie Translatable - CRITICAL

**ASLA `DB::table()` ile translatable veri ekleme!**

HasTranslations trait'i sadece Eloquent Model üzerinden çalışır. DB facade bypass eder.

### Translatable Models
| Model | Translatable Fields |
|-------|---------------------|
| Product | name, short_description, description |
| Category | name, description |
| Slider | title, subtitle, description, button_text |
| Banner | title, subtitle |
| HomeSection | title, subtitle |
| Feature | title, description |
| Menu | name |
| MenuItem | title |

---

## Laravel Localization Setup

- **3 dil:** TR (default), EN, DE
- **DB içerikleri:** `spatie/laravel-translatable` paketi
- **UI metinleri:** `lang/*.json` dosyaları
- **Middleware:** SetLocale - session'dan dil okur
- **Language switcher:** `/lang/{locale}` route
- **Toast:** Dil değişikliğinde toast YOK (user tercihi)

### UI Localization Pattern
```blade
{{-- Static text --}}
{{ __('Login') }}

{{-- Dynamic with parameter --}}
{{ __('All :name Products', ['name' => $category->name]) }}

{{-- Pluralization --}}
{{ __(':count Products', ['count' => $count]) }}
```

### Localized Files
- `lang/tr.json` - 400+ string
- `lang/en.json` - 400+ string
- `lang/de.json` - 400+ string
- `lang/tr/validation.php` - Validation mesajları
- `lang/en/validation.php` - Validation mesajları
- `lang/de/validation.php` - Validation mesajları

---

## File Upload Pattern

- **Location:** `public/uploads/{type}/`
- **Trait:** `HandlesFileUploads` in controllers
- **Accessor:** `$model->image_url` (auto-prepends uploads/)

---

## Admin Panel Design

- Stripe/Linear inspired minimal design
- Collapsible sidebar with LocalStorage persistence
- Component library: `resources/views/components/admin/`
- Language switcher in header (globe icon dropdown)

---

## Quick Debug Commands

```bash
# Clear all caches
php artisan config:clear && php artisan cache:clear && php artisan view:clear

# Fresh database with seeders
php artisan migrate:fresh --seed

# Dump autoload (after adding helpers)
composer dump-autoload
```

---

## Project File Locations

| Type | Location |
|------|----------|
| Seeders | `database/seeders/` |
| Translations | `lang/*.json`, `lang/*/validation.php` |
| Admin components | `resources/views/components/admin/` |
| Models | `app/Models/` |
| Knowledge docs | `.claude/knowledge/` |
| Memory | `.claude/MEMORY.md` (bu dosya) |
