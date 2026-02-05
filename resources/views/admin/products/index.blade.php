@extends('layouts.admin')

@section('title', __('Products'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Products') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Products') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __(':count products listed', ['count' => $products->total()]) }}</p>
        </div>
        <x-admin.button href="{{ route('admin.products.create') }}" icon="fa-plus">
            {{ __('New Product') }}
        </x-admin.button>
    </div>

    <!-- Filters -->
    <x-admin.card class="mb-6" :padding="false">
        <form action="{{ route('admin.products.index') }}" method="GET" class="p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <x-admin.form-input
                    name="search"
                    :placeholder="__('Product name or SKU...')"
                    :value="request('search')"
                    icon="fa-search"
                />

                <x-admin.form-select
                    name="category_id"
                    :value="request('category_id')"
                    :options="$categories->pluck('name', 'id')->toArray()"
                    :placeholder="__('All Categories')"
                />

                <x-admin.form-select
                    name="status"
                    :value="request('status')"
                    :options="[
                        'active' => __('Active'),
                        'inactive' => __('Inactive'),
                        'featured' => __('Featured'),
                        'on_sale' => __('On Sale'),
                        'low_stock' => __('Low Stock'),
                    ]"
                    :placeholder="__('All Statuses')"
                />

                <div class="flex gap-2 lg:col-span-2">
                    <x-admin.button type="submit" variant="secondary" icon="fa-filter" class="flex-1 sm:flex-none">
                        {{ __('Filter') }}
                    </x-admin.button>
                    @if(request()->hasAny(['search', 'category_id', 'status']))
                        <x-admin.button href="{{ route('admin.products.index') }}" variant="ghost">
                            {{ __('Clear') }}
                        </x-admin.button>
                    @endif
                </div>
            </div>
        </form>
    </x-admin.card>

    <!-- Products Table -->
    <x-admin.data-table :headers="[
        ['label' => __('Product'), 'width' => '35%'],
        __('Category'),
        ['label' => __('Price'), 'class' => 'text-right'],
        ['label' => __('Stock'), 'class' => 'text-center'],
        ['label' => __('Status'), 'class' => 'text-center'],
        ['label' => __('Actions'), 'class' => 'text-right', 'width' => '140px'],
    ]">
        @forelse($products as $product)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                        @else
                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                <i class="fas fa-image text-slate-400"></i>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-sm font-medium text-slate-900 hover:text-primary-600 line-clamp-1">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-slate-500">SKU: {{ $product->sku ?? '-' }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-600">{{ $product->category->name }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    @if($product->sale_price)
                        <div class="text-sm font-semibold text-rose-600">{{ number_format($product->sale_price, 2) }} TL</div>
                        <div class="text-xs text-slate-400 line-through">{{ number_format($product->price, 2) }} TL</div>
                    @else
                        <div class="text-sm font-semibold text-slate-900">{{ number_format($product->price, 2) }} TL</div>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    @php
                        $stockVariant = match(true) {
                            $product->stock == 0 => 'danger',
                            $product->stock <= 5 => 'warning',
                            default => 'success'
                        };
                    @endphp
                    <x-admin.badge :variant="$stockVariant" size="sm">
                        {{ $product->stock }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex flex-col items-center gap-1">
                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit">
                                <x-admin.badge :variant="$product->is_active ? 'success' : 'danger'" size="sm" dot>
                                    {{ $product->is_active ? __('Active') : __('Inactive') }}
                                </x-admin.badge>
                            </button>
                        </form>
                        @if($product->is_featured)
                            <span class="text-amber-500" title="{{ __('Featured') }}">
                                <i class="fas fa-star text-xs"></i>
                            </span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.products.show', $product) }}"
                           class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                           title="{{ __('Details') }}">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="{{ __('Edit') }}">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <a href="{{ route('products.show', $product) }}"
                           target="_blank"
                           class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                           title="{{ __('View on Site') }}">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="{{ __('Delete') }}">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-box"
                        :title="__('Product not found')"
                        :description="__('No products match your search criteria or no products have been added yet')"
                        :action="__('Add New Product')"
                        :actionUrl="route('admin.products.create')"
                    />
                </td>
            </tr>
        @endforelse

        <x-slot:footer>
            {{ $products->links() }}
        </x-slot:footer>
    </x-admin.data-table>
@endsection
