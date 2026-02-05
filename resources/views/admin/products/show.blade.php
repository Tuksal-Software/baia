@extends('layouts.admin')

@section('title', __('Product Detail'))

@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Products') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ Str::limit($product->name, 30) }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ $product->name }}</h1>
            <p class="text-sm text-slate-500 mt-1">SKU: {{ $product->sku ?? '-' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-admin.button href="{{ route('admin.products.edit', $product) }}" icon="fa-edit">
                {{ __('Edit') }}
            </x-admin.button>
            <x-admin.button href="{{ route('products.show', $product) }}" variant="ghost" icon="fa-external-link-alt" target="_blank">
                {{ __('View on Site') }}
            </x-admin.button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Images -->
            <x-admin.card :title="__('Images')">
                @if($product->images->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative">
                                <img src="{{ $image->image_url }}"
                                     alt="{{ $product->name }}"
                                     class="w-full aspect-square object-cover rounded-lg border {{ $image->is_primary ? 'border-primary-500 ring-2 ring-primary-200' : 'border-slate-200' }}">
                                @if($image->is_primary)
                                    <span class="absolute top-2 left-2 px-2 py-0.5 bg-primary-600 text-white text-xs rounded">
                                        {{ __('Main') }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-admin.empty-state
                        icon="fa-image"
                        :title="__('No images')"
                        :description="__('No images have been added to this product yet')"
                    />
                @endif
            </x-admin.card>

            <!-- Description -->
            <x-admin.card :title="__('Description')">
                @if($product->short_description)
                    <p class="text-slate-600 mb-4 font-medium">{{ $product->short_description }}</p>
                @endif

                @if($product->description)
                    <div class="prose prose-slate max-w-none text-sm">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                @else
                    <p class="text-slate-500 text-sm">{{ __('No description entered') }}</p>
                @endif
            </x-admin.card>

            <!-- Specifications -->
            @if($product->specifications->count() > 0)
                <x-admin.card :title="__('Technical Specifications')">
                    <div class="divide-y divide-slate-100">
                        @foreach($product->specifications as $spec)
                            <div class="py-3 flex justify-between text-sm">
                                <span class="text-slate-500">{{ $spec->key }}</span>
                                <span class="font-medium text-slate-900">{{ $spec->formatted_value }}</span>
                            </div>
                        @endforeach
                    </div>
                </x-admin.card>
            @endif

            <!-- Features -->
            @if($product->features->count() > 0)
                <x-admin.card :title="__('Product Features')">
                    <ul class="space-y-2">
                        @foreach($product->features as $feature)
                            <li class="flex items-center gap-3 text-sm">
                                <span class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </span>
                                <span class="text-slate-700">{{ $feature->feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </x-admin.card>
            @endif

            <!-- Reviews -->
            <x-admin.card :title="__('Reviews')" :subtitle="$product->reviews_count . ' ' . __('review')">
                @if($product->reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($product->reviews as $review)
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="flex text-amber-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-sm"></i>
                                                @endfor
                                            </div>
                                            <span class="text-sm font-medium text-slate-900">{{ $review->customer_name }}</span>
                                        </div>
                                        @if($review->comment)
                                            <p class="text-sm text-slate-600 mt-2">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                    <x-admin.badge :variant="$review->is_approved ? 'success' : 'warning'" size="sm">
                                        {{ $review->is_approved ? __('Approved') : __('Pending') }}
                                    </x-admin.badge>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-admin.empty-state
                        icon="fa-star"
                        :title="__('No reviews yet')"
                        :description="__('No reviews for this product yet')"
                    />
                @endif
            </x-admin.card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Info -->
            <x-admin.card :title="__('Information')">
                <dl class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <dt class="text-slate-500">{{ __('Category') }}</dt>
                        <dd class="font-medium text-slate-900">{{ $product->category->name }}</dd>
                    </div>
                    <div class="flex justify-between text-sm">
                        <dt class="text-slate-500">SKU</dt>
                        <dd class="font-medium text-slate-900">{{ $product->sku ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between text-sm">
                        <dt class="text-slate-500">{{ __('Price') }}</dt>
                        <dd class="font-semibold text-slate-900">{{ number_format($product->price, 2) }} {{ __('TL') }}</dd>
                    </div>
                    @if($product->sale_price)
                        <div class="flex justify-between text-sm">
                            <dt class="text-slate-500">{{ __('Discounted Price') }}</dt>
                            <dd class="font-semibold text-rose-600">{{ number_format($product->sale_price, 2) }} {{ __('TL') }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between text-sm">
                        <dt class="text-slate-500">{{ __('Stock') }}</dt>
                        <dd>
                            @php
                                $stockVariant = match(true) {
                                    $product->stock == 0 => 'danger',
                                    $product->stock <= 5 => 'warning',
                                    default => 'success'
                                };
                            @endphp
                            <x-admin.badge :variant="$stockVariant" size="sm">
                                {{ $product->stock }} {{ __('pieces') }}
                            </x-admin.badge>
                        </dd>
                    </div>
                    <div class="flex justify-between text-sm">
                        <dt class="text-slate-500">{{ __('Rating') }}</dt>
                        <dd class="flex items-center gap-1">
                            <i class="fas fa-star text-amber-400 text-xs"></i>
                            <span class="font-medium text-slate-900">{{ number_format($product->rating, 1) }}/5</span>
                            <span class="text-slate-400">({{ $product->reviews_count }})</span>
                        </dd>
                    </div>
                </dl>
            </x-admin.card>

            <!-- Status -->
            <x-admin.card :title="__('Status')">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        @if($product->is_active)
                            <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text-sm font-medium text-slate-900">{{ __('Active') }}</span>
                        @else
                            <span class="w-8 h-8 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </span>
                            <span class="text-sm font-medium text-slate-900">{{ __('Inactive') }}</span>
                        @endif
                    </div>

                    @if($product->is_featured)
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="text-sm font-medium text-slate-900">{{ __('Featured') }}</span>
                        </div>
                    @endif

                    @if($product->is_new)
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sparkles"></i>
                            </span>
                            <span class="text-sm font-medium text-slate-900">{{ __('New Product') }}</span>
                        </div>
                    @endif

                    @if($product->is_on_sale)
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tags"></i>
                            </span>
                            <span class="text-sm font-medium text-slate-900">{{ __('On Sale') }} (%{{ $product->discount_percentage }})</span>
                        </div>
                    @endif
                </div>
            </x-admin.card>

            <!-- Variants -->
            @if($product->variants->count() > 0)
                <x-admin.card :title="__('Variants')" :subtitle="$product->variants->count() . ' ' . __('variant')">
                    <div class="space-y-3">
                        @foreach($product->variants as $variant)
                            <div class="p-3 bg-slate-50 rounded-lg">
                                <p class="text-sm font-medium text-slate-900">{{ $variant->name }}</p>
                                <div class="flex items-center gap-3 mt-1 text-xs text-slate-500">
                                    <span>{{ __('Stock') }}: {{ $variant->stock }}</span>
                                    <span>{{ __('Price') }}: {{ $variant->price_difference >= 0 ? '+' : '' }}{{ number_format($variant->price_difference, 2) }} {{ __('TL') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-admin.card>
            @endif

            <!-- Dates -->
            <x-admin.card :title="__('Dates')">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">{{ __('Created') }}</dt>
                        <dd class="text-slate-900">{{ $product->created_at->format('d.m.Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">{{ __('Last Update') }}</dt>
                        <dd class="text-slate-900">{{ $product->updated_at->format('d.m.Y H:i') }}</dd>
                    </div>
                </dl>
            </x-admin.card>
        </div>
    </div>
@endsection
