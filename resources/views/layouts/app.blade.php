<!DOCTYPE html>
<html lang="tr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Baia Panel' }}</title>

    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-surface-alt font-sans antialiased" x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">

    <div class="flex h-full">

        {{-- Mobile Overlay --}}
        <div
            x-show="mobileSidebarOpen"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileSidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        ></div>

        {{-- Sidebar --}}
        <aside
            :class="{
                'w-64': sidebarOpen,
                'w-20': !sidebarOpen,
                'translate-x-0': mobileSidebarOpen,
                '-translate-x-full': !mobileSidebarOpen
            }"
            class="fixed inset-y-0 left-0 z-50 flex flex-col bg-sidebar-bg sidebar-transition
                   -translate-x-full lg:translate-x-0 lg:static lg:z-auto"
        >
            {{-- Logo --}}
            <div class="flex h-16 items-center justify-between px-4 border-b border-white/10">
                <a href="/dashboard" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-600 text-white font-bold text-lg flex-shrink-0">
                        B
                    </div>
                    <span
                        x-show="sidebarOpen"
                        x-transition:enter="transition-opacity duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        class="text-xl font-bold text-white whitespace-nowrap"
                    >
                        Baia
                    </span>
                </a>
                {{-- Collapse button (desktop) --}}
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="hidden lg:flex h-8 w-8 items-center justify-center rounded-lg text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-colors"
                >
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
                {{-- Close button (mobile) --}}
                <button
                    @click="mobileSidebarOpen = false"
                    class="lg:hidden flex h-8 w-8 items-center justify-center rounded-lg text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                {{-- Dashboard --}}
                <a href="/dashboard"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                          {{ request()->is('dashboard') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
                </a>

                {{-- Users --}}
                <a href="/users"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                          {{ request()->is('users*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Kullanıcılar</span>
                </a>

                {{-- Section Label --}}
                <div x-show="sidebarOpen" class="pt-4 pb-2 px-3">
                    <p class="text-xs font-semibold uppercase tracking-wider text-sidebar-text/50">Yönetim</p>
                </div>

                {{-- Settings --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-all duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Ayarlar</span>
                </a>

                {{-- Reports --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-all duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Raporlar</span>
                </a>
            </nav>

            {{-- User Profile (bottom) --}}
            <div class="border-t border-white/10 p-3">
                <div class="flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-sidebar-hover transition-colors cursor-pointer">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-500 text-white text-sm font-semibold flex-shrink-0">
                        HT
                    </div>
                    <div x-show="sidebarOpen" class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">Halil Tuksal</p>
                        <p class="text-xs text-sidebar-text truncate">Admin</p>
                    </div>
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sidebar-text ml-auto flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex flex-1 flex-col min-w-0">
            {{-- Top Header --}}
            <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-surface-border bg-surface px-4 lg:px-6 shadow-sm">
                {{-- Mobile menu button --}}
                <button
                    @click="mobileSidebarOpen = true"
                    class="lg:hidden flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 hover:bg-gray-100 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Page Title --}}
                <div class="flex-1">
                    <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-sm text-gray-500 hidden sm:block">@yield('page-subtitle', '')</p>
                </div>

                {{-- Header Actions --}}
                <div class="flex items-center gap-3">
                    {{-- Search --}}
                    <div class="hidden md:flex items-center gap-2 rounded-xl bg-gray-100 px-3 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Ara... (⌘K)" class="bg-transparent border-none text-sm text-gray-600 placeholder-gray-400 outline-none w-48">
                    </div>

                    {{-- Notifications --}}
                    <button class="relative flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                    </button>

                    {{-- User Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 rounded-xl px-2 py-1.5 hover:bg-gray-100 transition-colors">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-500 text-white text-xs font-semibold">
                                HT
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-lg ring-1 ring-black/5 py-1"
                        >
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">Halil Tuksal</p>
                                <p class="text-xs text-gray-500">halil@baia.com</p>
                            </div>
                            <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil
                            </a>
                            <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Ayarlar
                            </a>
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <a href="/login" class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Çıkış Yap
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
