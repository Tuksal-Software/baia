@extends('layouts.admin')

@section('title', __('Edit Product'))

@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Products') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ Str::limit($product->name, 30) }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit Product') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $product->name }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-admin.button href="{{ route('products.show', $product) }}" variant="ghost" icon="fa-external-link-alt" target="_blank">
                {{ __('View on Site') }}
            </x-admin.button>
            <form action="{{ route('admin.products.destroy', $product) }}"
                  method="POST"
                  onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                @csrf
                @method('DELETE')
                <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                    {{ __('Delete') }}
                </x-admin.button>
            </form>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <x-admin.card title="{{ __('Basic Information') }}">
                    <div class="space-y-4">
                        <x-admin.form-translatable-input
                            name="name"
                            label="{{ __('Product Name') }}"
                            :value="$product->getTranslations('name')"
                            required
                        />

                        <x-admin.form-input
                            name="slug"
                            label="{{ __('Slug') }}"
                            :value="$product->slug"
                        />

                        @php
                            $categoryOptions = [];
                            foreach($categories as $cat) {
                                $activeChildren = $cat->children->where('is_active', true);
                                if ($activeChildren->isEmpty()) {
                                    $categoryOptions[$cat->id] = $cat->name;
                                } else {
                                    // Parent category de seçilebilir
                                    $categoryOptions[$cat->id] = $cat->name;
                                    foreach ($activeChildren as $child) {
                                        $categoryOptions[$child->id] = $cat->name . ' → ' . $child->name;
                                    }
                                }
                            }
                        @endphp
                        <x-admin.form-select
                            name="category_id"
                            label="{{ __('Category') }}"
                            required
                            :value="$product->category_id"
                            :options="$categoryOptions"
                            placeholder="{{ __('Select category') }}"
                        />

                        <x-admin.form-translatable-textarea
                            name="short_description"
                            label="{{ __('Short Description') }}"
                            :value="$product->getTranslations('short_description')"
                            :rows="2"
                        />

                        <x-admin.form-translatable-textarea
                            name="description"
                            label="{{ __('Detailed Description') }}"
                            :value="$product->getTranslations('description')"
                            :rows="5"
                        />
                    </div>
                </x-admin.card>

                <!-- Current Images -->
                @if($product->images->count() > 0)
                    <x-admin.card title="{{ __('Current Images') }}">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach($product->images as $image)
                                <div class="relative group">
                                    <img src="{{ $image->image_url }}"
                                         alt="{{ $product->name }}"
                                         class="w-full aspect-square object-cover rounded-lg border {{ $image->is_primary ? 'border-primary-500 ring-2 ring-primary-200' : 'border-slate-200' }}">

                                    @if($image->is_primary)
                                        <span class="absolute top-2 left-2 px-2 py-0.5 bg-primary-600 text-white text-xs rounded">
                                            {{ __('Main Image') }}
                                        </span>
                                    @endif

                                    <div class="absolute inset-0 bg-slate-900/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center gap-2">
                                        @if(!$image->is_primary)
                                            <form action="{{ route('admin.products.set-primary-image', $image) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="p-2 bg-white text-slate-700 rounded-lg hover:bg-primary-50 hover:text-primary-600"
                                                        title="{{ __('Set as main image') }}">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.products.delete-image', $image) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 bg-white text-slate-700 rounded-lg hover:bg-rose-50 hover:text-rose-600"
                                                    title="{{ __('Delete') }}"
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this image?') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-admin.card>
                @endif

                <!-- New Images -->
                <x-admin.card title="{{ __('Add New Images') }}">
                    <x-admin.form-image
                        name="images"
                        multiple
                        hint="{{ __('New images will be added to existing images') }}"
                    />
                </x-admin.card>

                <!-- Specifications -->
                <x-admin.card title="{{ __('Technical Specifications') }}">
                    <div x-data="{ specs: {{ json_encode($product->specifications->map(fn($s) => ['key' => $s->key, 'value' => $s->value, 'unit' => $s->unit])->toArray() ?: [['key' => '', 'value' => '', 'unit' => '']]) }} }">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="grid grid-cols-12 gap-3 mb-3">
                                <div class="col-span-4">
                                    <input type="text"
                                           :name="'specifications['+index+'][key]'"
                                           x-model="spec.key"
                                           placeholder="{{ __('Property') }}"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
                                <div class="col-span-4">
                                    <input type="text"
                                           :name="'specifications['+index+'][value]'"
                                           x-model="spec.value"
                                           placeholder="{{ __('Value') }}"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
                                <div class="col-span-3">
                                    <input type="text"
                                           :name="'specifications['+index+'][unit]'"
                                           x-model="spec.unit"
                                           placeholder="{{ __('Unit') }}"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
                                <div class="col-span-1 flex items-center justify-center">
                                    <button type="button"
                                            @click="specs.splice(index, 1)"
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <x-admin.button type="button"
                                        @click="specs.push({ key: '', value: '', unit: '' })"
                                        variant="ghost"
                                        size="sm"
                                        icon="fa-plus">
                            {{ __('Add Specification') }}
                        </x-admin.button>
                    </div>
                </x-admin.card>

                <!-- Features -->
                <x-admin.card title="{{ __('Product Features') }}">
                    <div x-data="{ features: {{ json_encode($product->features->pluck('feature')->toArray() ?: ['']) }} }">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex gap-3 mb-3">
                                <input type="text"
                                       :name="'features['+index+']'"
                                       x-model="features[index]"
                                       placeholder="{{ __('Feature') }}"
                                       class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                <button type="button"
                                        @click="features.splice(index, 1)"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </template>

                        <x-admin.button type="button"
                                        @click="features.push('')"
                                        variant="ghost"
                                        size="sm"
                                        icon="fa-plus">
                            {{ __('Add Feature') }}
                        </x-admin.button>
                    </div>
                </x-admin.card>

                <!-- Variants -->
                <x-admin.card title="{{ __('Variants') }}">
                    <div x-data="{ variants: {{ json_encode($product->variants->map(fn($v) => ['id' => $v->id, 'name' => $v->name, 'sku' => $v->sku, 'price_difference' => $v->price_difference, 'stock' => $v->stock, 'is_active' => $v->is_active])->toArray()) }} }">
                        <template x-for="(variant, index) in variants" :key="index">
                            <div class="p-4 bg-slate-50 rounded-lg mb-3">
                                <input type="hidden" :name="'variants['+index+'][id]'" x-model="variant.id">
                                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Variant Name') }}</label>
                                        <input type="text"
                                               :name="'variants['+index+'][name]'"
                                               x-model="variant.name"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('SKU') }}</label>
                                        <input type="text"
                                               :name="'variants['+index+'][sku]'"
                                               x-model="variant.sku"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Price Difference') }}</label>
                                        <input type="number"
                                               :name="'variants['+index+'][price_difference]'"
                                               x-model="variant.price_difference"
                                               step="0.01"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Stock') }}</label>
                                        <input type="number"
                                               :name="'variants['+index+'][stock]'"
                                               x-model="variant.stock"
                                               min="0"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button"
                                                @click="variants.splice(index, 1)"
                                                class="w-full p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors text-sm">
                                            <i class="fas fa-trash mr-1"></i> {{ __('Remove') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <x-admin.button type="button"
                                        @click="variants.push({ id: null, name: '', sku: '', price_difference: 0, stock: 0, is_active: true })"
                                        variant="ghost"
                                        size="sm"
                                        icon="fa-plus">
                            {{ __('Add Variant') }}
                        </x-admin.button>
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Price & Stock -->
                <x-admin.card :title="__('Price & Stock')">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="currency"
                            label="{{ __('Currency') }}"
                            required
                            :options="[
                                'TRY' => '₺ ' . __('Turkish Lira'),
                                'USD' => '$ ' . __('US Dollar'),
                                'EUR' => '€ ' . __('Euro'),
                            ]"
                            :value="old('currency', $product->currency ?? 'TRY')"
                        />

                        <x-admin.form-input
                            name="price"
                            type="number"
                            label="{{ __('Price') }}"
                            :value="$product->price"
                            step="0.01"
                            min="0"
                            required
                        />

                        <x-admin.form-input
                            name="sale_price"
                            type="number"
                            label="{{ __('Sale Price') }}"
                            :value="$product->sale_price"
                            step="0.01"
                            min="0"
                        />

                        <x-admin.form-input
                            name="sku"
                            label="{{ __('SKU') }}"
                            :value="$product->sku"
                        />

                        <x-admin.form-input
                            name="stock"
                            type="number"
                            label="{{ __('Stock Quantity') }}"
                            :value="$product->stock"
                            min="0"
                        />
                    </div>
                </x-admin.card>

                <!-- Status -->
                <x-admin.card title="{{ __('Status') }}">
                    <div class="space-y-4">
                        <x-admin.form-toggle
                            name="is_active"
                            label="{{ __('Active') }}"
                            description="{{ __('Product is visible on the site') }}"
                            :checked="$product->is_active"
                        />

                        <x-admin.form-toggle
                            name="is_featured"
                            label="{{ __('Featured') }}"
                            description="{{ __('Shown in featured products on homepage') }}"
                            :checked="$product->is_featured"
                        />

                        <x-admin.form-toggle
                            name="is_new"
                            label="{{ __('New Product') }}"
                            description="{{ __('New product badge is shown') }}"
                            :checked="$product->is_new"
                        />
                    </div>
                </x-admin.card>

                <!-- Info -->
                <x-admin.card title="{{ __('Information') }}">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Created') }}</span>
                            <span class="text-slate-900">{{ $product->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Last Updated') }}</span>
                            <span class="text-slate-900">{{ $product->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>

                <!-- Actions -->
                <x-admin.card>
                    <div class="space-y-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            {{ __('Save Changes') }}
                        </x-admin.button>
                        <x-admin.button href="{{ route('admin.products.index') }}" variant="ghost" class="w-full">
                            {{ __('Cancel') }}
                        </x-admin.button>
                    </div>
                </x-admin.card>
            </div>
        </div>
    </form>
@endsection
