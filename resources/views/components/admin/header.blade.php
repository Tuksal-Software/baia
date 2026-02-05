<header class="h-16 bg-white border-b border-slate-200 sticky top-0 z-20">
    <div class="h-full flex items-center justify-between px-4 lg:px-6">
        <!-- Left: Mobile menu + Breadcrumb -->
        <div class="flex items-center gap-4">
            <!-- Mobile Menu Button -->
            <button @click="mobileSidebar = true"
                    class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <!-- Breadcrumb -->
            <div class="hidden sm:flex items-center gap-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-700">
                    <i class="fas fa-home"></i>
                </a>
                @hasSection('breadcrumb')
                    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
                    @yield('breadcrumb')
                @endif
            </div>
        </div>

        <!-- Right: Actions + User Menu -->
        <div class="flex items-center gap-2">
            <!-- Quick Actions -->
            <a href="{{ route('admin.products.create') }}"
               class="hidden sm:flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                <i class="fas fa-plus text-xs"></i>
                <span>Yeni Urun</span>
            </a>

            <!-- User Menu -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                    <div class="w-7 h-7 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center">
                        <span class="text-xs font-medium">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <span class="hidden sm:inline font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                </button>

                <!-- Dropdown -->
                <div x-show="open"
                     x-cloak
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50">
                    <div class="px-4 py-2 border-b border-slate-100">
                        <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>

                    <a href="{{ route('admin.settings.index') }}"
                       class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-cog text-slate-400 w-4"></i>
                        Ayarlar
                    </a>

                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-external-link-alt text-slate-400 w-4"></i>
                        Siteyi Gor
                    </a>

                    <div class="border-t border-slate-100 my-1"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">
                            <i class="fas fa-sign-out-alt w-4"></i>
                            Cikis Yap
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
