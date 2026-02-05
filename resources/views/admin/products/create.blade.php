@extends('layouts.admin')

@section('title', __('New Product'))

@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Products') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New Product') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New Product') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Add a new product') }}</p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <x-admin.card title="{{ __('Basic Information') }}">
                    <div class="space-y-4">
                        <x-admin.form-translatable-input
                            name="name"
                            label="{{ __('Product Name') }}"
                            placeholder="{{ __('Enter product name') }}"
                            required
                        />

                        <x-admin.form-input
                            name="slug"
                            label="{{ __('Slug') }}"
                            placeholder="{{ __('Auto-generated') }}"
                            hint="{{ __('Leave empty to auto-generate from product name') }}"
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
                            :options="$categoryOptions"
                            placeholder="{{ __('Select category') }}"
                        />

                        <x-admin.form-translatable-textarea
                            name="short_description"
                            label="{{ __('Short Description') }}"
                            :rows="2"
                            placeholder="{{ __('Brief description about the product') }}"
                            hint="{{ __('Maximum 500 characters') }}"
                        />

                        <x-admin.form-translatable-textarea
                            name="description"
                            label="{{ __('Detailed Description') }}"
                            :rows="5"
                            placeholder="{{ __('Detailed product description') }}"
                        />
                    </div>
                </x-admin.card>

                <!-- Images -->
                <x-admin.card title="{{ __('Images') }}">
                    <x-admin.form-image
                        name="images"
                        label="{{ __('Product Images') }}"
                        multiple
                        hint="{{ __('You can select multiple images. First image will be the main image.') }}"
                    />
                </x-admin.card>

                <!-- Specifications -->
                <x-admin.card title="{{ __('Technical Specifications') }}">
                    <p class="text-sm text-slate-500 mb-4">{{ __('Add technical specifications like size, material, weight') }}</p>

                    <div x-data="{ specs: [{ key: '', value: '', unit: '' }] }">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="grid grid-cols-12 gap-3 mb-3">
                                <div class="col-span-4">
                                    <input type="text"
                                           :name="'specifications['+index+'][key]'"
                                           x-model="spec.key"
                                           placeholder="{{ __('Property (e.g. Size)') }}"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
                                <div class="col-span-4">
                                    <input type="text"
                                           :name="'specifications['+index+'][value]'"
                                           x-model="spec.value"
                                           placeholder="{{ __('Value (e.g. 120x80)') }}"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
                                <div class="col-span-3">
                                    <input type="text"
                                           :name="'specifications['+index+'][unit]'"
                                           x-model="spec.unit"
                                           placeholder="{{ __('Unit (e.g. cm)') }}"
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
                    <p class="text-sm text-slate-500 mb-4">{{ __('List the key features of the product (shown as checkmark list)') }}</p>

                    <div x-data="{ features: [''] }">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex gap-3 mb-3">
                                <div class="flex-1">
                                    <input type="text"
                                           :name="'features['+index+']'"
                                           x-model="features[index]"
                                           placeholder="{{ __('Feature (e.g. Easy-clean surface)') }}"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
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
                    <p class="text-sm text-slate-500 mb-4">{{ __('Add product variants like color, size') }}</p>

                    <div x-data="{ variants: [] }">
                        <template x-for="(variant, index) in variants" :key="index">
                            <div class="p-4 bg-slate-50 rounded-lg mb-3">
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Variant Name') }}</label>
                                        <input type="text"
                                               :name="'variants['+index+'][name]'"
                                               x-model="variant.name"
                                               placeholder="{{ __('e.g. Red') }}"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('SKU') }}</label>
                                        <input type="text"
                                               :name="'variants['+index+'][sku]'"
                                               x-model="variant.sku"
                                               placeholder="{{ __('Optional') }}"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Price Difference') }}</label>
                                        <input type="number"
                                               :name="'variants['+index+'][price_difference]'"
                                               x-model="variant.price_difference"
                                               step="0.01"
                                               placeholder="0.00"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Stock') }}</label>
                                        <input type="number"
                                               :name="'variants['+index+'][stock]'"
                                               x-model="variant.stock"
                                               min="0"
                                               placeholder="0"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                </div>
                                <div class="mt-3 text-right">
                                    <button type="button"
                                            @click="variants.splice(index, 1)"
                                            class="text-sm text-rose-600 hover:text-rose-700">
                                        <i class="fas fa-trash mr-1"></i> {{ __('Remove Variant') }}
                                    </button>
                                </div>
                            </div>
                        </template>

                        <x-admin.button type="button"
                                        @click="variants.push({ name: '', sku: '', price_difference: 0, stock: 0 })"
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
                            :value="old('currency', 'TRY')"
                        />

                        <x-admin.form-input
                            name="price"
                            type="number"
                            label="{{ __('Price') }}"
                            step="0.01"
                            min="0"
                            required
                        />

                        <x-admin.form-input
                            name="sale_price"
                            type="number"
                            label="{{ __('Sale Price') }}"
                            step="0.01"
                            min="0"
                            hint="{{ __('Leave empty if no discount') }}"
                        />

                        <x-admin.form-input
                            name="sku"
                            label="{{ __('SKU') }}"
                            placeholder="{{ __('Stock Code') }}"
                        />

                        <x-admin.form-input
                            name="stock"
                            type="number"
                            label="{{ __('Stock Quantity') }}"
                            min="0"
                            :value="0"
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
                            :checked="true"
                        />

                        <x-admin.form-toggle
                            name="is_featured"
                            label="{{ __('Featured') }}"
                            description="{{ __('Shown in featured products on homepage') }}"
                        />

                        <x-admin.form-toggle
                            name="is_new"
                            label="{{ __('New Product') }}"
                            description="{{ __('New product badge is shown') }}"
                        />
                    </div>
                </x-admin.card>

                <!-- Actions -->
                <x-admin.card>
                    <div class="space-y-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            {{ __('Save Product') }}
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
