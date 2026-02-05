<!DOCTYPE html>
<html lang="tr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - BAIA Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#EEF2FF',
                            100: '#E0E7FF',
                            200: '#C7D2FE',
                            300: '#A5B4FC',
                            400: '#818CF8',
                            500: '#6366F1',
                            600: '#4F46E5',
                            700: '#4338CA',
                            800: '#3730A3',
                            900: '#312E81',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar transition */
        .sidebar-transition {
            transition: width 200ms ease-in-out;
        }
        .content-transition {
            transition: margin-left 200ms ease-in-out;
        }

        /* Tooltip */
        .tooltip {
            visibility: hidden;
            opacity: 0;
            transition: opacity 150ms, visibility 150ms;
        }
        .tooltip-trigger:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="h-full bg-slate-50 font-sans antialiased" x-data="{
    sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
    mobileSidebar: false,
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
    }
}">
    <div class="min-h-full flex">
        <!-- Sidebar -->
        <x-admin.sidebar />

        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileSidebar"
             x-cloak
             class="lg:hidden fixed inset-0 z-40"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="mobileSidebar = false"></div>
            <aside class="absolute left-0 top-0 bottom-0 w-64 bg-white shadow-xl flex flex-col"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="-translate-x-full"
                   x-transition:enter-end="translate-x-0"
                   x-transition:leave="transition ease-in duration-150"
                   x-transition:leave-start="translate-x-0"
                   x-transition:leave-end="-translate-x-full">
                <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">B</span>
                        </div>
                        <span class="font-semibold text-slate-900">BAIA Admin</span>
                    </a>
                    <button @click="mobileSidebar = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex-1 overflow-y-auto p-3">
                    @include('components.admin.sidebar-nav', ['mobile' => true])
                </nav>
            </aside>
        </div>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-16'" class="flex-1 content-transition">
            <!-- Header -->
            <x-admin.header />

            <!-- Page Content -->
            <main class="p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <x-admin.alert type="success" class="mb-6" dismissible>
                        {{ session('success') }}
                    </x-admin.alert>
                @endif

                @if(session('error'))
                    <x-admin.alert type="danger" class="mb-6" dismissible>
                        {{ session('error') }}
                    </x-admin.alert>
                @endif

                @if(session('warning'))
                    <x-admin.alert type="warning" class="mb-6" dismissible>
                        {{ session('warning') }}
                    </x-admin.alert>
                @endif

                @if($errors->any())
                    <x-admin.alert type="danger" class="mb-6" dismissible>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-admin.alert>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2"></div>

    <script>
        // Toast notification helper
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const colors = {
                success: 'bg-emerald-500',
                error: 'bg-rose-500',
                warning: 'bg-amber-500',
                info: 'bg-primary-500'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            toast.className = `${colors[type]} text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 transform translate-x-full transition-transform duration-300`;
            toast.innerHTML = `
                <i class="fas ${icons[type]}"></i>
                <span class="text-sm font-medium">${message}</span>
            `;

            container.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full');
            });

            // Remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
    </script>
    @stack('scripts')
</body>
</html>
