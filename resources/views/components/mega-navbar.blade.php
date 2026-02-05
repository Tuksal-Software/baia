@props(['categories', 'menuItems' => null])

<div class="hidden lg:block" x-data="megaNav()" x-ref="megaNavWrapper">
    {{-- Main Navigation Bar --}}
    <nav class="border-t border-gray-100 relative bg-white" x-ref="nav">
        <div class="container mx-auto px-4">
            <ul class="flex items-center justify-center gap-1">
                {{-- Dynamic Categories --}}
                @foreach($categories as $category)
                    <li class="relative"
                        @mouseenter="openMenu('category-{{ $category->id }}')"
                        @mouseleave="startCloseTimer()">
                        <a href="{{ route('categories.show', $category) }}"
                           class="flex items-center gap-1.5 px-4 py-4 text-sm font-medium text-gray-700 hover:text-black transition-colors uppercase tracking-wider"
                           :class="activeMenu === 'category-{{ $category->id }}' ? 'text-black' : ''">
                            {{ $category->name }}
                            @if($category->children->where('is_active', true)->count() > 0)
                                <svg class="w-3 h-3 transition-transform duration-200"
                                     :class="activeMenu === 'category-{{ $category->id }}' ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            @endif
                        </a>
                    </li>
                @endforeach

                {{-- Static Menu Items --}}
                @if($menuItems)
                    @foreach($menuItems->where('is_active', true) as $item)
                        @php
                            $isCategory = str_contains($item->link, '/kategori/') || str_contains($item->link, '/categories/');
                        @endphp
                        @unless($isCategory)
                            <li class="relative"
                                @if($item->children && $item->children->where('is_active', true)->count() > 0)
                                    @mouseenter="openMenu('menu-{{ $item->id }}')"
                                    @mouseleave="startCloseTimer()"
                                @endif>
                                <a href="{{ $item->link }}"
                                   target="{{ $item->target ?? '_self' }}"
                                   class="flex items-center gap-1.5 px-4 py-4 text-sm font-medium text-gray-700 hover:text-black transition-colors uppercase tracking-wider"
                                   :class="activeMenu === 'menu-{{ $item->id }}' ? 'text-black' : ''">
                                    {{ $item->title }}
                                    @if($item->children && $item->children->where('is_active', true)->count() > 0)
                                        <svg class="w-3 h-3 transition-transform duration-200"
                                             :class="activeMenu === 'menu-{{ $item->id }}' ? 'rotate-180' : ''"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @endif
                                </a>
                            </li>
                        @endunless
                    @endforeach
                @endif
            </ul>
        </div>
    </nav>

    {{-- Dropdown Panel - Directly attached to nav (no gap) --}}
    <div class="relative"
         x-show="activeMenu !== null"
         @mouseenter="cancelCloseTimer()"
         @mouseleave="closeMenu()">

        {{-- Category Mega Menus --}}
        @foreach($categories as $category)
            @if($category->children->where('is_active', true)->count() > 0)
                <div x-show="activeMenu === 'category-{{ $category->id }}'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="absolute left-0 right-0 top-0 bg-white border-t border-gray-100 shadow-xl z-50"
                     x-cloak>
                    <div class="container mx-auto px-4 py-8">
                        <div class="grid grid-cols-12 gap-8">
                            {{-- Subcategories --}}
                            <div class="col-span-9">
                                <div class="grid grid-cols-4 gap-8">
                                    @foreach($category->children->where('is_active', true)->take(8) as $child)
                                        <div>
                                            <a href="{{ route('categories.show', $child) }}"
                                               class="block text-sm font-semibold text-black uppercase tracking-wider mb-3 hover:text-gray-600 transition-colors">
                                                {{ $child->name }}
                                            </a>
                                            @if($child->children->where('is_active', true)->count() > 0)
                                                <ul class="space-y-2">
                                                    @foreach($child->children->where('is_active', true)->take(6) as $subChild)
                                                        <li>
                                                            <a href="{{ route('categories.show', $subChild) }}"
                                                               class="text-sm text-gray-600 hover:text-black transition-colors">
                                                                {{ $subChild->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                {{-- View All Link --}}
                                <div class="mt-8 pt-6 border-t border-gray-100">
                                    <a href="{{ route('categories.show', $category) }}"
                                       class="inline-flex items-center gap-2 text-sm font-medium text-black hover:text-gray-600 transition-colors uppercase tracking-wider">
                                        Tum {{ $category->name }} Urunleri
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            {{-- Category Image --}}
                            <div class="col-span-3">
                                @if($category->image_url)
                                    <a href="{{ route('categories.show', $category) }}" class="block relative group overflow-hidden aspect-[4/5]">
                                        <img src="{{ $category->image_url }}"
                                             alt="{{ $category->name }}"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <span class="inline-block bg-white text-black text-xs font-semibold px-4 py-2 uppercase tracking-wider">
                                                Koleksiyonu Kesfet
                                            </span>
                                        </div>
                                    </a>
                                @else
                                    <div class="bg-gray-100 aspect-[4/5] flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">{{ $category->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Static Menu Item Dropdowns --}}
        @if($menuItems)
            @foreach($menuItems->where('is_active', true) as $item)
                @if($item->children && $item->children->where('is_active', true)->count() > 0)
                    @php $isCategory = str_contains($item->link, '/kategori/') || str_contains($item->link, '/categories/'); @endphp
                    @unless($isCategory)
                        <div x-show="activeMenu === 'menu-{{ $item->id }}'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="absolute left-0 right-0 top-0 bg-white border-t border-gray-100 shadow-xl z-50"
                             x-cloak>
                            <div class="container mx-auto px-4 py-6">
                                <div class="grid grid-cols-4 gap-6">
                                    @foreach($item->children->where('is_active', true) as $child)
                                        <a href="{{ $child->link }}"
                                           target="{{ $child->target ?? '_self' }}"
                                           class="block p-4 hover:bg-gray-50 rounded-lg transition-colors">
                                            <span class="text-sm font-medium text-black">{{ $child->title }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endunless
                @endif
            @endforeach
        @endif
    </div>

    {{-- Overlay --}}
    <div x-show="activeMenu !== null"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeMenu()"
         class="fixed inset-0 bg-black/10 z-40"
         :style="'top: ' + overlayTop + 'px'"
         x-cloak>
    </div>
</div>

<script>
function megaNav() {
    return {
        activeMenu: null,
        closeTimer: null,
        overlayTop: 0,

        init() {
            this.updateOverlayTop();
            window.addEventListener('resize', () => this.updateOverlayTop());
            window.addEventListener('scroll', () => this.updateOverlayTop());
        },

        updateOverlayTop() {
            if (this.$refs.megaNavWrapper) {
                const rect = this.$refs.megaNavWrapper.getBoundingClientRect();
                this.overlayTop = rect.bottom + window.scrollY;
            }
        },

        openMenu(menu) {
            this.cancelCloseTimer();
            this.activeMenu = menu;
        },

        closeMenu() {
            this.activeMenu = null;
        },

        startCloseTimer() {
            this.closeTimer = setTimeout(() => {
                this.closeMenu();
            }, 150);
        },

        cancelCloseTimer() {
            if (this.closeTimer) {
                clearTimeout(this.closeTimer);
                this.closeTimer = null;
            }
        }
    }
}
</script>
