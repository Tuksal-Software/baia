<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteSettings['site_name'] ?? 'BAIA') - {{ $siteSettings['site_name'] ?? 'BAIA' }}</title>
    <meta name="description" content="@yield('description', $siteSettings['meta_description'] ?? '')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        beige: {
                            50: '#fdfbf7',
                            100: '#f5f5dc',
                            200: '#e8e4d4',
                            300: '#d4cfc0',
                            400: '#b8b29f',
                        },
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
    </style>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-white min-h-screen flex flex-col">
    <!-- Announcement Bar -->
    @if(($siteSettings['header_announcement_active'] ?? false) && ($siteSettings['header_announcement'] ?? ''))
        <div class="bg-black text-white text-sm py-2">
            <div class="container mx-auto px-4 text-center">
                @if($siteSettings['header_announcement_link'] ?? false)
                    <a href="{{ $siteSettings['header_announcement_link'] }}" class="hover:underline">
                        {{ $siteSettings['header_announcement'] }}
                    </a>
                @else
                    {{ $siteSettings['header_announcement'] }}
                @endif
            </div>
        </div>
    @endif

    <!-- Header -->
    <header class="bg-white sticky top-0 z-50 shadow-sm" x-data="{ mobileMenu: false, searchOpen: false, accountOpen: false }">
        <!-- Main Header -->
        <div class="border-b border-gray-100">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 -ml-2 text-gray-700 hover:text-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex-shrink-0">
                        @if($siteSettings['site_logo'] ?? false)
                            <img src="{{ image_url($siteSettings['site_logo'], 'settings') }}" alt="{{ $siteSettings['site_name'] ?? 'BAIA' }}" class="h-8 lg:h-10">
                        @else
                            <span class="text-2xl lg:text-3xl font-serif font-bold text-black tracking-tight">{{ $siteSettings['site_name'] ?? 'BAIA' }}</span>
                        @endif
                    </a>

                    <!-- Right Icons -->
                    <div class="flex items-center gap-1 lg:gap-2">
                        <!-- Search -->
                        <button @click="searchOpen = !searchOpen" class="p-2 text-gray-700 hover:text-black transition-colors" title="Ara">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>

                        <!-- Account -->
                        <div class="relative" @click.outside="accountOpen = false">
                            <button @click="accountOpen = !accountOpen" class="p-2 text-gray-700 hover:text-black transition-colors" title="Hesabim">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </button>
                            <!-- Account Dropdown -->
                            <div x-show="accountOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 class="absolute right-0 top-full mt-2 w-56 bg-white border border-gray-100 shadow-lg py-2 z-50">
                                @auth
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Admin Panel
                                        </a>
                                    @endif
                                    <a href="{{ route('checkout.track') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        Siparislerim
                                    </a>
                                    <div class="border-t border-gray-100 mt-1 pt-1">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 text-left">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                                Cikis Yap
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="px-4 py-3">
                                        <a href="{{ route('login') }}" class="block w-full py-2.5 px-4 bg-black text-white text-center text-sm uppercase tracking-wider hover:bg-gray-800 transition-colors">
                                            Giris Yap
                                        </a>
                                        <a href="{{ route('register') }}" class="block w-full py-2.5 px-4 mt-2 border border-black text-black text-center text-sm uppercase tracking-wider hover:bg-black hover:text-white transition-colors">
                                            Kayit Ol
                                        </a>
                                    </div>
                                    <div class="border-t border-gray-100 mt-1 pt-1">
                                        <a href="{{ route('checkout.track') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            Siparis Takip
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>

                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-black transition-colors" title="Sepetim">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span id="cart-count" class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mega Navigation -->
        <x-mega-navbar :categories="$navCategories" :menu-items="$headerMenu?->rootItems" />

        <!-- Search Overlay -->
        <div x-show="searchOpen" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute top-full left-0 right-0 bg-white border-b shadow-lg z-40">
            <div class="container mx-auto px-4 py-6">
                <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Urun ara..." value="{{ request('q') }}"
                               class="w-full px-4 py-3 border-b-2 border-black focus:outline-none text-lg bg-transparent"
                               x-ref="searchInput"
                               @keydown.escape="searchOpen = false">
                        <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 p-2 text-gray-600 hover:text-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <button type="button" @click="searchOpen = false" class="absolute right-12 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-black">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <div class="absolute inset-0 -z-10" @click="searchOpen = false"></div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-cloak class="lg:hidden fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black/50" @click="mobileMenu = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>
            <div class="absolute left-0 top-0 bottom-0 w-80 max-w-[85vw] bg-white overflow-y-auto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                <!-- Mobile Header -->
                <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                    <span class="font-serif text-xl font-bold">{{ $siteSettings['site_name'] ?? 'BAIA' }}</span>
                    <button @click="mobileMenu = false" class="p-2 text-gray-500 hover:text-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Navigation - Categories -->
                <nav class="py-2">
                    @foreach($navCategories as $category)
                        @if($category->children->where('is_active', true)->count() > 0)
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center justify-between w-full px-6 py-3 text-gray-700 hover:bg-gray-50 uppercase text-sm tracking-wider font-medium">
                                    <span>{{ $category->name }}</span>
                                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open" x-collapse class="bg-gray-50">
                                    <a href="{{ route('categories.show', $category) }}" class="block px-8 py-2 text-sm text-gray-600 hover:text-black font-medium">
                                        Tum {{ $category->name }}
                                    </a>
                                    @foreach($category->children->where('is_active', true) as $child)
                                        <a href="{{ route('categories.show', $child) }}" class="block px-8 py-2 text-sm text-gray-600 hover:text-black">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ route('categories.show', $category) }}"
                               class="block px-6 py-3 text-gray-700 hover:bg-gray-50 uppercase text-sm tracking-wider font-medium">
                                {{ $category->name }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Additional menu items --}}
                    @if($headerMenu && $headerMenu->rootItems)
                        <div class="border-t mt-2 pt-2">
                            @foreach($headerMenu->rootItems->where('is_active', true) as $item)
                                @php $isCategory = str_contains($item->link, '/kategori/') || str_contains($item->link, '/categories/'); @endphp
                                @unless($isCategory)
                                    <a href="{{ $item->link }}"
                                       target="{{ $item->target ?? '_self' }}"
                                       class="block px-6 py-3 text-gray-600 hover:bg-gray-50 text-sm">
                                        {{ $item->title }}
                                    </a>
                                @endunless
                            @endforeach
                        </div>
                    @endif
                </nav>

                <!-- Mobile Account Section -->
                <div class="border-t p-4 space-y-2">
                    @auth
                        <div class="pb-2 mb-2 border-b">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 py-2 text-sm text-gray-700 hover:text-black">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Admin Panel
                            </a>
                        @endif
                        <a href="{{ route('checkout.track') }}" class="flex items-center gap-2 py-2 text-sm text-gray-700 hover:text-black">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Siparislerim
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 py-2 text-sm text-gray-700 hover:text-black">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cikis Yap
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-2.5 bg-black text-white text-center text-sm uppercase tracking-wider">
                            Giris Yap
                        </a>
                        <a href="{{ route('register') }}" class="block w-full py-2.5 border border-black text-black text-center text-sm uppercase tracking-wider">
                            Kayit Ol
                        </a>
                        <a href="{{ route('checkout.track') }}" class="flex items-center gap-2 py-2 mt-2 text-sm text-gray-700 hover:text-black">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Siparis Takip
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success') || session('error') || session('warning'))
        <div class="container mx-auto px-4 mt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded" role="alert">
                    {{ session('warning') }}
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white mt-16">
        <!-- Footer Features -->
        @if(isset($footerFeatures) && $footerFeatures->count() > 0)
            <div class="border-b border-gray-800">
                <div class="container mx-auto px-4 py-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        @foreach($footerFeatures as $feature)
                            <div class="flex flex-col items-center">
                                <span class="text-white/80 text-sm font-medium">{{ $feature->title }}</span>
                                @if($feature->description)
                                    <span class="text-white/50 text-xs mt-1">{{ $feature->description }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="font-serif text-xl font-bold mb-4">{{ $siteSettings['site_name'] ?? 'BAIA' }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        {{ $siteSettings['footer_about'] ?? 'Kaliteli ve sik mobilyalar ile evinizi guzelleştirin.' }}
                    </p>
                    <div class="flex gap-4 mt-6">
                        @if($siteSettings['social_facebook'] ?? false)
                            <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($siteSettings['social_instagram'] ?? false)
                            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if($siteSettings['social_pinterest'] ?? false)
                            <a href="{{ $siteSettings['social_pinterest'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        @endif
                        @if($siteSettings['social_twitter'] ?? false)
                            <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        @endif
                        @if($siteSettings['social_youtube'] ?? false)
                            <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Footer Menu 1 -->
                @if($footerMenu && $footerMenu->rootItems)
                    <div>
                        <h4 class="font-semibold uppercase text-sm tracking-wider mb-4">{{ $footerMenu->name }}</h4>
                        <ul class="space-y-3 text-sm">
                            @foreach($footerMenu->rootItems->where('is_active', true) as $item)
                                <li>
                                    <a href="{{ $item->link }}" class="text-gray-400 hover:text-white transition-colors">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Footer Menu 2 -->
                @if($footerSecondaryMenu && $footerSecondaryMenu->rootItems)
                    <div>
                        <h4 class="font-semibold uppercase text-sm tracking-wider mb-4">{{ $footerSecondaryMenu->name }}</h4>
                        <ul class="space-y-3 text-sm">
                            @foreach($footerSecondaryMenu->rootItems->where('is_active', true) as $item)
                                <li>
                                    <a href="{{ $item->link }}" class="text-gray-400 hover:text-white transition-colors">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold uppercase text-sm tracking-wider mb-4">Iletisim</h4>
                    <ul class="space-y-3 text-sm">
                        @if($siteSettings['contact_address'] ?? false)
                            <li class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt mt-1 text-gray-500"></i>
                                <span class="text-gray-400">{{ $siteSettings['contact_address'] }}</span>
                            </li>
                        @endif
                        @if($siteSettings['contact_phone'] ?? false)
                            <li class="flex items-center gap-3">
                                <i class="fas fa-phone text-gray-500"></i>
                                <a href="tel:{{ $siteSettings['contact_phone'] }}" class="text-gray-400 hover:text-white">
                                    {{ $siteSettings['contact_phone'] }}
                                </a>
                            </li>
                        @endif
                        @if($siteSettings['contact_email'] ?? false)
                            <li class="flex items-center gap-3">
                                <i class="fas fa-envelope text-gray-500"></i>
                                <a href="mailto:{{ $siteSettings['contact_email'] }}" class="text-gray-400 hover:text-white">
                                    {{ $siteSettings['contact_email'] }}
                                </a>
                            </li>
                        @endif
                        @if($siteSettings['contact_working_hours'] ?? false)
                            <li class="flex items-center gap-3">
                                <i class="fas fa-clock text-gray-500"></i>
                                <span class="text-gray-400">{{ $siteSettings['contact_working_hours'] }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Payment Icons & Copyright -->
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-500">
                        {{ $siteSettings['footer_copyright'] ?? '© ' . date('Y') . ' BAIA. Tum haklari saklidir.' }}
                    </p>
                    @if($siteSettings['footer_payment_icons'] ?? true)
                        <div class="flex gap-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/100px-Visa_Inc._logo.svg.png" alt="Visa" class="h-6 opacity-50">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/100px-Mastercard-logo.svg.png" alt="Mastercard" class="h-6 opacity-50">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Button -->
    @if($siteSettings['contact_phone'] ?? false)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_phone']) }}" target="_blank"
           class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition z-50">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    @endif

    <script>
        async function updateCartCount() {
            try {
                const response = await fetch('{{ route("cart.data") }}');
                const data = await response.json();
                document.getElementById('cart-count').textContent = data.total_items || 0;
            } catch (e) {}
        }
        updateCartCount();
    </script>
    @stack('scripts')
</body>
</html>
