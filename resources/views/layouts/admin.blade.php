<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Baia Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>[x-cloak] { display: none !important; }</style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true, mobileSidebar: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="hidden lg:block bg-gray-800 text-white transition-all duration-300 fixed h-full z-30">
            <div class="p-4 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <span class="text-2xl font-bold text-purple-400">B</span>
                    <span x-show="sidebarOpen" class="font-semibold">BAIA Admin</span>
                </a>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-home w-5"></i><span x-show="sidebarOpen">Dashboard</span></a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-folder w-5"></i><span x-show="sidebarOpen">Kategoriler</span></a></li>
                    <li><a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-box w-5"></i><span x-show="sidebarOpen">Urunler</span></a></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-shopping-bag w-5"></i><span x-show="sidebarOpen">Siparisler</span></a></li>
                    <li><a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.reviews.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-star w-5"></i><span x-show="sidebarOpen">Yorumlar</span></a></li>
                    <li><a href="{{ route('admin.discount-codes.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.discount-codes.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-tags w-5"></i><span x-show="sidebarOpen">Indirim Kodlari</span></a></li>
                </ul>

                <!-- CMS Section -->
                <div class="border-t border-gray-700 mt-4 pt-4">
                    <p x-show="sidebarOpen" class="px-3 mb-2 text-xs text-gray-500 uppercase tracking-wider">Icerik Yonetimi</p>
                    <ul class="space-y-2">
                        <li><a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.sliders.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-images w-5"></i><span x-show="sidebarOpen">Sliderlar</span></a></li>
                        <li><a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.banners.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-ad w-5"></i><span x-show="sidebarOpen">Bannerlar</span></a></li>
                        <li><a href="{{ route('admin.home-sections.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.home-sections.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-th-large w-5"></i><span x-show="sidebarOpen">Ana Sayfa</span></a></li>
                        <li><a href="{{ route('admin.features.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.features.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-check-circle w-5"></i><span x-show="sidebarOpen">Ozellikler</span></a></li>
                        <li><a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.menus.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-bars w-5"></i><span x-show="sidebarOpen">Menuler</span></a></li>
                        <li><a href="{{ route('admin.newsletter.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.newsletter.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-envelope w-5"></i><span x-show="sidebarOpen">Bulten</span></a></li>
                        <li><a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-purple-600' : 'hover:bg-gray-700' }}"><i class="fas fa-cog w-5"></i><span x-show="sidebarOpen">Ayarlar</span></a></li>
                    </ul>
                </div>

                <div class="border-t border-gray-700 mt-4 pt-4">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700 text-gray-400"><i class="fas fa-external-link-alt w-5"></i><span x-show="sidebarOpen">Siteyi Gor</span></a>
                </div>
            </nav>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileSidebar" x-cloak class="lg:hidden fixed inset-0 z-40">
            <div class="absolute inset-0 bg-black/50" @click="mobileSidebar = false"></div>
            <aside class="absolute left-0 top-0 bottom-0 w-64 bg-gray-800 text-white">
                <div class="p-4 border-b border-gray-700 flex justify-between items-center">
                    <span class="font-semibold">BAIA Admin</span>
                    <button @click="mobileSidebar = false" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                </div>
                <nav class="p-4 overflow-y-auto max-h-[calc(100vh-60px)]">
                    <ul class="space-y-2">
                        <li><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-home w-5"></i> Dashboard</a></li>
                        <li><a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-folder w-5"></i> Kategoriler</a></li>
                        <li><a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-box w-5"></i> Urunler</a></li>
                        <li><a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-shopping-bag w-5"></i> Siparisler</a></li>
                        <li><a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-star w-5"></i> Yorumlar</a></li>
                        <li><a href="{{ route('admin.discount-codes.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-tags w-5"></i> Indirim Kodlari</a></li>
                    </ul>
                    <div class="border-t border-gray-700 mt-4 pt-4">
                        <p class="px-3 mb-2 text-xs text-gray-500 uppercase">Icerik Yonetimi</p>
                        <ul class="space-y-2">
                            <li><a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-images w-5"></i> Sliderlar</a></li>
                            <li><a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-ad w-5"></i> Bannerlar</a></li>
                            <li><a href="{{ route('admin.home-sections.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-th-large w-5"></i> Ana Sayfa</a></li>
                            <li><a href="{{ route('admin.features.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-check-circle w-5"></i> Ozellikler</a></li>
                            <li><a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-bars w-5"></i> Menuler</a></li>
                            <li><a href="{{ route('admin.newsletter.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-envelope w-5"></i> Bulten</a></li>
                            <li><a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-cog w-5"></i> Ayarlar</a></li>
                        </ul>
                    </div>
                </nav>
            </aside>
        </div>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="flex-1 transition-all duration-300">
            <header class="bg-white shadow-sm sticky top-0 z-20">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center gap-4">
                        <button @click="mobileSidebar = true" class="lg:hidden text-gray-600"><i class="fas fa-bars text-xl"></i></button>
                        <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-600"><i class="fas fa-bars text-xl"></i></button>
                        <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="text-gray-600 hover:text-gray-800"><i class="fas fa-sign-out-alt"></i></button></form>
                    </div>
                </div>
            </header>
            <main class="p-6">
                @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
                @if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif
                @if($errors->any())<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"><ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
