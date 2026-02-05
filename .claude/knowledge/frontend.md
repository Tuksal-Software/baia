# BAIA Frontend Structure

## Technology Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| Blade | Laravel built-in | Template engine |
| Tailwind CSS | 4.0.0 | Utility-first CSS |
| Vite | 7.0.7 | Build tool |
| Axios | 1.11.0 | HTTP client |
| Alpine.js | (önerilir) | Lightweight JS |

---

## View Structure (73+ Templates)

```
resources/views/
├── layouts/
│   ├── app.blade.php           # Main layout (header, footer, nav)
│   └── admin.blade.php         # Admin panel layout
│
├── components/                  # Reusable Blade components
│   ├── banner.blade.php
│   ├── category-cards.blade.php
│   ├── features-bar.blade.php
│   ├── hero-slider.blade.php
│   ├── newsletter-section.blade.php
│   ├── product-card.blade.php
│   ├── product-card-minimal.blade.php
│   └── product-carousel.blade.php
│
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
│
├── products/
│   ├── index.blade.php         # Product listing
│   ├── show.blade.php          # Product detail
│   ├── featured.blade.php      # Featured products
│   ├── new.blade.php           # New products
│   └── sale.blade.php          # Sale products
│
├── categories/
│   ├── index.blade.php         # All categories
│   └── show.blade.php          # Category products
│
├── cart/
│   └── index.blade.php         # Shopping cart
│
├── checkout/
│   ├── index.blade.php         # Checkout form
│   ├── confirmation.blade.php  # Order confirmation
│   └── track.blade.php         # Order tracking
│
├── pages/
│   ├── about.blade.php         # About page
│   └── contact.blade.php       # Contact page
│
├── users/
│   ├── index.blade.php
│   └── create.blade.php
│
├── admin/
│   ├── dashboard.blade.php
│   ├── products/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── categories/
│   ├── orders/
│   ├── reviews/
│   ├── discount-codes/
│   ├── sliders/
│   ├── banners/
│   ├── home-sections/
│   ├── features/
│   ├── menus/
│   ├── settings/
│   └── newsletter/
│
├── home.blade.php              # Homepage
├── welcome.blade.php           # Welcome page
├── search.blade.php            # Search results
└── dashboard.blade.php         # User dashboard
```

---

## Layout Structure

### Main Layout (layouts/app.blade.php)

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
```

### Admin Layout (layouts/admin.blade.php)

```blade
<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex">
        @include('admin.partials.sidebar')

        <div class="flex-1">
            @include('admin.partials.topbar')

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
```

---

## Blade Components

### Product Card
```blade
{{-- resources/views/components/product-card.blade.php --}}
@props(['product'])

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <a href="{{ route('products.show', $product->slug) }}">
        <img src="{{ $product->primaryImage?->image_path }}"
             alt="{{ $product->name }}"
             class="w-full h-48 object-cover">
    </a>

    <div class="p-4">
        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>

        <div class="mt-2">
            @if($product->is_on_sale)
                <span class="text-red-500 font-bold">{{ $product->current_price }} TL</span>
                <span class="text-gray-400 line-through">{{ $product->price }} TL</span>
            @else
                <span class="font-bold">{{ $product->price }} TL</span>
            @endif
        </div>

        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Sepete Ekle
            </button>
        </form>
    </div>
</div>
```

### Hero Slider
```blade
{{-- resources/views/components/hero-slider.blade.php --}}
@props(['sliders'])

<div class="relative" x-data="{ current: 0 }">
    @foreach($sliders as $index => $slider)
        <div x-show="current === {{ $index }}" class="relative">
            <img src="{{ $slider->image }}" class="w-full h-96 object-cover">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h2 class="text-4xl font-bold">{{ $slider->title }}</h2>
                    <p class="mt-2">{{ $slider->subtitle }}</p>
                    @if($slider->link)
                        <a href="{{ $slider->link }}" class="mt-4 inline-block bg-white text-black px-6 py-2 rounded">
                            {{ $slider->button_text ?? 'Keşfet' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    {{-- Navigation dots --}}
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @foreach($sliders as $index => $slider)
            <button @click="current = {{ $index }}"
                    :class="current === {{ $index }} ? 'bg-white' : 'bg-white/50'"
                    class="w-3 h-3 rounded-full"></button>
        @endforeach
    </div>
</div>
```

---

## CSS Structure

### Main CSS (resources/css/app.css)

```css
@import 'tailwindcss';

/* Custom utilities */
@layer utilities {
    .text-balance {
        text-wrap: balance;
    }
}

/* Custom components */
@layer components {
    .btn-primary {
        @apply bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition;
    }

    .btn-secondary {
        @apply bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition;
    }

    .form-input {
        @apply w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500;
    }
}
```

---

## JavaScript Structure

### Main JS (resources/js/app.js)

```javascript
import './bootstrap';

// Alpine.js initialization (if used)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Common functions
window.addToCart = async function(productId, quantity = 1, variantId = null) {
    const response = await axios.post('/sepet/ekle', {
        product_id: productId,
        quantity: quantity,
        variant_id: variantId
    });

    // Update cart count in header
    document.querySelector('#cart-count').textContent = response.data.cart_count;
};
```

### Bootstrap JS (resources/js/bootstrap.js)

```javascript
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF token
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
```

---

## Vite Configuration

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

---

## Form Patterns

### CSRF Token
```blade
<form method="POST" action="{{ route('...') }}">
    @csrf
    ...
</form>
```

### Method Spoofing
```blade
<form method="POST" action="{{ route('...') }}">
    @csrf
    @method('PUT')  {{-- or DELETE, PATCH --}}
    ...
</form>
```

### Validation Errors
```blade
<input type="text" name="email" value="{{ old('email') }}"
       class="@error('email') border-red-500 @enderror">
@error('email')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
```

---

## Admin Panel Patterns

### Data Table with Actions
```blade
<table class="w-full">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr class="border-b">
                <td class="p-3">{{ $item->id }}</td>
                <td class="p-3">{{ $item->name }}</td>
                <td class="p-3">
                    <a href="{{ route('admin.items.edit', $item) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $items->links() }}
```

### Flash Messages
```blade
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
```
