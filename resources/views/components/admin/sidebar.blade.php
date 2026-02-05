<!-- Desktop Sidebar -->
<aside :class="sidebarOpen ? 'w-64' : 'w-16'"
       class="hidden lg:flex flex-col bg-white border-r border-slate-200 fixed h-full z-30 sidebar-transition">
    <!-- Logo -->
    <div class="h-16 flex items-center px-4 border-b border-slate-200">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-sm">B</span>
            </div>
            <span x-show="sidebarOpen" x-cloak class="font-semibold text-slate-900">BAIA Admin</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-3">
        @include('components.admin.sidebar-nav')
    </nav>

    <!-- Collapse Toggle -->
    <div class="p-3 border-t border-slate-200">
        <button @click="toggleSidebar()"
                class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
            <i class="fas" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
            <span x-show="sidebarOpen" x-cloak>Daralt</span>
        </button>
    </div>
</aside>
