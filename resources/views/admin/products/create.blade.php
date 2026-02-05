@extends('layouts.admin')

@section('title', 'Yeni Urun')

@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}" class="text-slate-500 hover:text-slate-700">Urunler</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Urun</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Urun</h1>
        <p class="text-sm text-slate-500 mt-1">Yeni bir urun ekleyin</p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            label="Urun Adi"
                            placeholder="Urun adini girin"
                            required
                        />

                        <x-admin.form-input
                            name="slug"
                            label="Slug"
                            placeholder="Otomatik olusturulur"
                            hint="Bos birakırsaniz urun adindan otomatik olusturulur"
                        />

                        <x-admin.form-select
                            name="category_id"
                            label="Kategori"
                            required
                            :options="$categories->flatMap(function($cat) {
                                $options = [];
                                if ($cat->children->isEmpty()) {
                                    $options[$cat->id] = $cat->name;
                                } else {
                                    foreach ($cat->children as $child) {
                                        $options[$child->id] = $cat->name . ' > ' . $child->name;
                                    }
                                }
                                return $options;
                            })->toArray()"
                            placeholder="Kategori secin"
                        />

                        <x-admin.form-textarea
                            name="short_description"
                            label="Kisa Aciklama"
                            :rows="2"
                            placeholder="Urun hakkinda kisa bir aciklama"
                            hint="Maksimum 500 karakter"
                        />

                        <x-admin.form-textarea
                            name="description"
                            label="Detayli Aciklama"
                            :rows="5"
                            placeholder="Urunun detayli aciklamasi"
                        />
                    </div>
                </x-admin.card>

                <!-- Images -->
                <x-admin.card title="Gorseller">
                    <x-admin.form-image
                        name="images"
                        label="Urun Gorselleri"
                        multiple
                        hint="Birden fazla gorsel secebilirsiniz. Ilk gorsel ana gorsel olacaktir."
                    />
                </x-admin.card>

                <!-- Specifications -->
                <x-admin.card title="Teknik Ozellikler">
                    <p class="text-sm text-slate-500 mb-4">Boyut, malzeme, agirlik gibi teknik ozellikleri ekleyin</p>

                    <div x-data="{ specs: [{ key: '', value: '', unit: '' }] }">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="grid grid-cols-12 gap-3 mb-3">
                                <div class="col-span-4">
                                    <input type="text"
                                           :name="'specifications['+index+'][key]'"
                                           x-model="spec.key"
                                           placeholder="Ozellik (ör: Boyut)"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
                                <div class="col-span-4">
                                    <input type="text"
                                           :name="'specifications['+index+'][value]'"
                                           x-model="spec.value"
                                           placeholder="Deger (ör: 120x80)"
                                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                </div>
                                <div class="col-span-3">
                                    <input type="text"
                                           :name="'specifications['+index+'][unit]'"
                                           x-model="spec.unit"
                                           placeholder="Birim (ör: cm)"
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
                            Ozellik Ekle
                        </x-admin.button>
                    </div>
                </x-admin.card>

                <!-- Features -->
                <x-admin.card title="Urun Ozellikleri">
                    <p class="text-sm text-slate-500 mb-4">Urunun one cikan ozelliklerini listeleyin (checkmark listesi olarak gorunur)</p>

                    <div x-data="{ features: [''] }">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex gap-3 mb-3">
                                <div class="flex-1">
                                    <input type="text"
                                           :name="'features['+index+']'"
                                           x-model="features[index]"
                                           placeholder="Ozellik (ör: Kolay temizlenebilir yuzey)"
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
                            Ozellik Ekle
                        </x-admin.button>
                    </div>
                </x-admin.card>

                <!-- Variants -->
                <x-admin.card title="Varyantlar">
                    <p class="text-sm text-slate-500 mb-4">Renk, boyut gibi urun varyantlarini ekleyin</p>

                    <div x-data="{ variants: [] }">
                        <template x-for="(variant, index) in variants" :key="index">
                            <div class="p-4 bg-slate-50 rounded-lg mb-3">
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Varyant Adi</label>
                                        <input type="text"
                                               :name="'variants['+index+'][name]'"
                                               x-model="variant.name"
                                               placeholder="ör: Kirmizi"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">SKU</label>
                                        <input type="text"
                                               :name="'variants['+index+'][sku]'"
                                               x-model="variant.sku"
                                               placeholder="Opsiyonel"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Fiyat Farki (TL)</label>
                                        <input type="number"
                                               :name="'variants['+index+'][price_difference]'"
                                               x-model="variant.price_difference"
                                               step="0.01"
                                               placeholder="0.00"
                                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Stok</label>
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
                                        <i class="fas fa-trash mr-1"></i> Varyanti Kaldir
                                    </button>
                                </div>
                            </div>
                        </template>

                        <x-admin.button type="button"
                                        @click="variants.push({ name: '', sku: '', price_difference: 0, stock: 0 })"
                                        variant="ghost"
                                        size="sm"
                                        icon="fa-plus">
                            Varyant Ekle
                        </x-admin.button>
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Price & Stock -->
                <x-admin.card title="Fiyat & Stok">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="price"
                            type="number"
                            label="Fiyat"
                            step="0.01"
                            min="0"
                            required
                            suffix="TL"
                        />

                        <x-admin.form-input
                            name="sale_price"
                            type="number"
                            label="Indirimli Fiyat"
                            step="0.01"
                            min="0"
                            suffix="TL"
                            hint="Indirim yoksa bos birakin"
                        />

                        <x-admin.form-input
                            name="sku"
                            label="SKU"
                            placeholder="Stok Kodu"
                        />

                        <x-admin.form-input
                            name="stock"
                            type="number"
                            label="Stok Miktari"
                            min="0"
                            :value="0"
                        />
                    </div>
                </x-admin.card>

                <!-- Status -->
                <x-admin.card title="Durum">
                    <div class="space-y-4">
                        <x-admin.form-toggle
                            name="is_active"
                            label="Aktif"
                            description="Urun sitede gorunur"
                            :checked="true"
                        />

                        <x-admin.form-toggle
                            name="is_featured"
                            label="One Cikan"
                            description="Ana sayfada one cikan urunlerde gosterilir"
                        />

                        <x-admin.form-toggle
                            name="is_new"
                            label="Yeni Urun"
                            description="Yeni urun etiketi gosterilir"
                        />
                    </div>
                </x-admin.card>

                <!-- Actions -->
                <x-admin.card>
                    <div class="space-y-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            Urunu Kaydet
                        </x-admin.button>
                        <x-admin.button href="{{ route('admin.products.index') }}" variant="ghost" class="w-full">
                            Iptal
                        </x-admin.button>
                    </div>
                </x-admin.card>
            </div>
        </div>
    </form>
@endsection
