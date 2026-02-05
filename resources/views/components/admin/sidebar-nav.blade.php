@php
    $navigation = [
        [
            'group' => __('Main'),
            'items' => [
                ['name' => __('Dashboard'), 'route' => 'admin.dashboard', 'icon' => 'fa-home'],
                ['name' => __('Products'), 'route' => 'admin.products.*', 'href' => 'admin.products.index', 'icon' => 'fa-box'],
                ['name' => __('Categories'), 'route' => 'admin.categories.*', 'href' => 'admin.categories.index', 'icon' => 'fa-folder'],
                ['name' => __('Orders'), 'route' => 'admin.orders.*', 'href' => 'admin.orders.index', 'icon' => 'fa-shopping-bag'],
                ['name' => __('Reviews'), 'route' => 'admin.reviews.*', 'href' => 'admin.reviews.index', 'icon' => 'fa-star'],
                ['name' => __('Discount Codes'), 'route' => 'admin.discount-codes.*', 'href' => 'admin.discount-codes.index', 'icon' => 'fa-tags'],
            ]
        ],
        [
            'group' => __('Content Management'),
            'items' => [
                ['name' => __('Sliders'), 'route' => 'admin.sliders.*', 'href' => 'admin.sliders.index', 'icon' => 'fa-images'],
                ['name' => __('Banners'), 'route' => 'admin.banners.*', 'href' => 'admin.banners.index', 'icon' => 'fa-ad'],
                ['name' => __('Home Sections'), 'route' => 'admin.home-sections.*', 'href' => 'admin.home-sections.index', 'icon' => 'fa-th-large'],
                ['name' => __('Features'), 'route' => 'admin.features.*', 'href' => 'admin.features.index', 'icon' => 'fa-check-circle'],
                ['name' => __('Menus'), 'route' => 'admin.menus.*', 'href' => 'admin.menus.index', 'icon' => 'fa-bars'],
            ]
        ],
        [
            'group' => __('System'),
            'items' => [
                ['name' => __('Users'), 'route' => 'admin.users.*', 'href' => 'admin.users.index', 'icon' => 'fa-users'],
                ['name' => __('Settings'), 'route' => 'admin.settings.*', 'href' => 'admin.settings.index', 'icon' => 'fa-cog'],
                ['name' => __('Newsletter Subscribers'), 'route' => 'admin.newsletter.*', 'href' => 'admin.newsletter.index', 'icon' => 'fa-envelope'],
            ]
        ],
    ];

    $mobile = $mobile ?? false;
@endphp

@foreach($navigation as $section)
    @if(!$loop->first)
        <div class="my-3 border-t border-slate-200"></div>
    @endif

    @if($mobile || true)
        <p x-show="{{ $mobile ? 'true' : 'sidebarOpen' }}"
           x-cloak
           class="px-3 mb-2 text-xs font-medium text-slate-400 uppercase tracking-wider">
            {{ $section['group'] }}
        </p>
    @endif

    <ul class="space-y-1">
        @foreach($section['items'] as $item)
            @php
                $isActive = request()->routeIs($item['route']);
                $href = isset($item['href']) ? route($item['href']) : route($item['route']);
                $routeExists = Route::has($item['href'] ?? $item['route']);
            @endphp

            @if($routeExists)
                <li class="tooltip-trigger relative">
                    <a href="{{ $href }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ $isActive
                                  ? 'bg-primary-50 text-primary-700'
                                  : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas {{ $item['icon'] }} w-5 text-center {{ $isActive ? 'text-primary-600' : 'text-slate-400' }}"></i>
                        <span x-show="{{ $mobile ? 'true' : 'sidebarOpen' }}" x-cloak>{{ $item['name'] }}</span>
                    </a>

                    @if(!$mobile)
                        <!-- Tooltip for collapsed state -->
                        <div x-show="!sidebarOpen"
                             x-cloak
                             class="tooltip absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded whitespace-nowrap z-50">
                            {{ $item['name'] }}
                        </div>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endforeach

<!-- Site Link -->
<div class="mt-3 pt-3 border-t border-slate-200">
    <a href="{{ route('home') }}"
       target="_blank"
       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors">
        <i class="fas fa-external-link-alt w-5 text-center text-slate-400"></i>
        <span x-show="{{ $mobile ? 'true' : 'sidebarOpen' }}" x-cloak>{{ __('View on Site') }}</span>
    </a>
</div>
