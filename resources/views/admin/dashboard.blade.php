@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('Dashboard') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Welcome to BAIA e-commerce admin panel') }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-admin.stats-card
            :title="__('Total Products')"
            :value="$stats['total_products']"
            icon="fa-box"
            color="primary"
            :href="route('admin.products.index')"
        />

        <x-admin.stats-card
            :title="__('Total Orders')"
            :value="$stats['total_orders']"
            icon="fa-shopping-bag"
            color="info"
            :href="route('admin.orders.index')"
        />

        <x-admin.stats-card
            :title="__('Pending Orders')"
            :value="$stats['pending_orders']"
            icon="fa-clock"
            color="warning"
            :href="route('admin.orders.index') . '?status=pending'"
        />

        <x-admin.stats-card
            :title="__('Pending Reviews')"
            :value="$stats['pending_reviews']"
            icon="fa-star"
            color="success"
            :href="route('admin.reviews.index') . '?status=pending'"
        />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Orders -->
        <x-admin.card :title="__('Recent Orders')" :subtitle="__('Last 10 orders')">
            <x-slot:actions>
                <x-admin.button href="{{ route('admin.orders.index') }}" variant="ghost" size="sm">
                    {{ __('View All') }}
                </x-admin.button>
            </x-slot:actions>

            @if($recentOrders->count() > 0)
                <div class="space-y-3">
                    @foreach($recentOrders->take(5) as $order)
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-bag text-slate-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $order->order_number }}</p>
                                    <p class="text-xs text-slate-500">{{ $order->customer_name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900">{{ number_format($order->total, 2) }} {{ __('TL') }}</p>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'preparing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp
                                <x-admin.badge :variant="$statusColors[$order->status] ?? 'default'" size="sm" dot>
                                    {{ __($order->status) }}
                                </x-admin.badge>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <x-admin.empty-state
                    icon="fa-shopping-bag"
                    :title="__('No orders yet')"
                    :description="__('Orders will appear here')"
                />
            @endif
        </x-admin.card>

        <!-- Low Stock Products -->
        <x-admin.card :title="__('Low Stock Products')" :subtitle="__('Stock quantity 5 and below')">
            <x-slot:actions>
                <x-admin.button href="{{ route('admin.products.index') }}?stock=low" variant="ghost" size="sm">
                    {{ __('View All') }}
                </x-admin.button>
            </x-slot:actions>

            @if($lowStockProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-slate-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-slate-900 line-clamp-1">{{ $product->name }}</p>
                                    <p class="text-xs text-slate-500">{{ __('SKU') }}: {{ $product->sku ?? '-' }}</p>
                                </div>
                            </div>
                            <x-admin.badge :variant="$product->stock == 0 ? 'danger' : 'warning'" size="sm">
                                {{ $product->stock }} {{ __('pieces') }}
                            </x-admin.badge>
                        </a>
                    @endforeach
                </div>
            @else
                <x-admin.empty-state
                    icon="fa-box"
                    :title="__('All products in stock')"
                    :description="__('No low stock products found')"
                />
            @endif
        </x-admin.card>
    </div>

    <!-- Quick Actions -->
    <x-admin.card :title="__('Quick Actions')" :subtitle="__('Frequently used actions')">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.products.create') }}"
               class="flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-primary-300 hover:bg-primary-50 transition-colors group">
                <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                    <i class="fas fa-plus text-lg"></i>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-primary-700">{{ __('New Product') }}</span>
            </a>

            <a href="{{ route('admin.categories.create') }}"
               class="flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 transition-colors group">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class="fas fa-folder-plus text-lg"></i>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-emerald-700">{{ __('New Category') }}</span>
            </a>

            <a href="{{ route('admin.discount-codes.create') }}"
               class="flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-colors group">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class="fas fa-tags text-lg"></i>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-amber-700">{{ __('Discount Codes') }}</span>
            </a>

            <a href="{{ route('admin.orders.export') }}"
               class="flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-sky-50 transition-colors group">
                <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center group-hover:bg-sky-200 transition-colors">
                    <i class="fas fa-download text-lg"></i>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-sky-700">{{ __('Order Report') }}</span>
            </a>
        </div>
    </x-admin.card>

    <!-- Order Status Overview -->
    @if($ordersByStatus->count() > 0)
        <x-admin.card :title="__('Order Status Overview')" class="mt-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $statusConfig = [
                        'pending' => ['label' => __('Pending'), 'color' => 'bg-amber-100 text-amber-700', 'icon' => 'fa-clock'],
                        'confirmed' => ['label' => __('Confirmed'), 'color' => 'bg-sky-100 text-sky-700', 'icon' => 'fa-check'],
                        'preparing' => ['label' => __('Preparing'), 'color' => 'bg-indigo-100 text-indigo-700', 'icon' => 'fa-box'],
                        'shipped' => ['label' => __('Shipped'), 'color' => 'bg-purple-100 text-purple-700', 'icon' => 'fa-truck'],
                        'delivered' => ['label' => __('Delivered'), 'color' => 'bg-emerald-100 text-emerald-700', 'icon' => 'fa-check-circle'],
                        'cancelled' => ['label' => __('Cancelled'), 'color' => 'bg-rose-100 text-rose-700', 'icon' => 'fa-times-circle'],
                    ];
                @endphp
                @foreach($statusConfig as $status => $config)
                    <div class="p-4 rounded-xl {{ $config['color'] }}">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas {{ $config['icon'] }} text-sm"></i>
                            <span class="text-xs font-medium uppercase tracking-wider">{{ $config['label'] }}</span>
                        </div>
                        <p class="text-2xl font-semibold">{{ $ordersByStatus[$status] ?? 0 }}</p>
                    </div>
                @endforeach
            </div>
        </x-admin.card>
    @endif
@endsection
