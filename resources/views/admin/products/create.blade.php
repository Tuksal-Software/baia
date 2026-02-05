@extends('layouts.admin')
@section('title', 'Yeni Urun')
@section('content')
<div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">Yeni Urun</h2></div>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Temel Bilgiler</h3>
                <div class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Urun Adi *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug') }}" placeholder="Otomatik olusturulur" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label><select name="category_id" required class="w-full border rounded-lg px-4 py-2"><option value="">Secin</option>@foreach($categories as $cat)<optgroup label="{{ $cat->name }}">@foreach($cat->children as $child)<option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>@endforeach @if($cat->children->isEmpty())<option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endif</optgroup>@endforeach</select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Kisa Aciklama</label><textarea name="short_description" rows="2" class="w-full border rounded-lg px-4 py-2">{{ old('short_description') }}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Aciklama</label><textarea name="description" rows="5" class="w-full border rounded-lg px-4 py-2">{{ old('description') }}</textarea></div>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Gorseller</h3>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border rounded-lg px-4 py-2">
                <p class="text-xs text-gray-500 mt-1">Birden fazla gorsel secebilirsiniz. Ilk gorsel ana gorsel olacaktir.</p>
            </div>

            <!-- Specifications -->
            <div class="bg-white rounded-lg p-6" x-data="{ specs: [{ key: '', value: '', unit: '' }] }">
                <h3 class="font-semibold mb-4">Ozellikler (Boyut, Malzeme vb.)</h3>
                <template x-for="(spec, index) in specs" :key="index">
                    <div class="grid grid-cols-4 gap-2 mb-2">
                        <input type="text" :name="'specifications['+index+'][key]'" x-model="spec.key" placeholder="Ozellik" class="border rounded px-3 py-2">
                        <input type="text" :name="'specifications['+index+'][value]'" x-model="spec.value" placeholder="Deger" class="border rounded px-3 py-2">
                        <input type="text" :name="'specifications['+index+'][unit]'" x-model="spec.unit" placeholder="Birim" class="border rounded px-3 py-2">
                        <button type="button" @click="specs.splice(index, 1)" class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </template>
                <button type="button" @click="specs.push({ key: '', value: '', unit: '' })" class="text-purple-600 text-sm"><i class="fas fa-plus mr-1"></i>Ozellik Ekle</button>
            </div>

            <!-- Features -->
            <div class="bg-white rounded-lg p-6" x-data="{ features: [''] }">
                <h3 class="font-semibold mb-4">Ozellikler (Checkmark Listesi)</h3>
                <template x-for="(feature, index) in features" :key="index">
                    <div class="flex gap-2 mb-2">
                        <input type="text" :name="'features['+index+']'" x-model="features[index]" placeholder="Ozellik" class="flex-1 border rounded px-3 py-2">
                        <button type="button" @click="features.splice(index, 1)" class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </template>
                <button type="button" @click="features.push('')" class="text-purple-600 text-sm"><i class="fas fa-plus mr-1"></i>Ozellik Ekle</button>
            </div>

            <!-- Variants -->
            <div class="bg-white rounded-lg p-6" x-data="{ variants: [] }">
                <h3 class="font-semibold mb-4">Varyantlar (Renk, Boyut vb.)</h3>
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="grid grid-cols-5 gap-2 mb-2">
                        <input type="text" :name="'variants['+index+'][name]'" x-model="variant.name" placeholder="Varyant Adi" class="border rounded px-3 py-2">
                        <input type="text" :name="'variants['+index+'][sku]'" x-model="variant.sku" placeholder="SKU" class="border rounded px-3 py-2">
                        <input type="number" :name="'variants['+index+'][price_difference]'" x-model="variant.price_difference" placeholder="Fiyat Farki" step="0.01" class="border rounded px-3 py-2">
                        <input type="number" :name="'variants['+index+'][stock]'" x-model="variant.stock" placeholder="Stok" min="0" class="border rounded px-3 py-2">
                        <button type="button" @click="variants.splice(index, 1)" class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </template>
                <button type="button" @click="variants.push({ name: '', sku: '', price_difference: 0, stock: 0 })" class="text-purple-600 text-sm"><i class="fas fa-plus mr-1"></i>Varyant Ekle</button>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Fiyat & Stok</h3>
                <div class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Fiyat (TL) *</label><input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Indirimli Fiyat (TL)</label><input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">SKU</label><input type="text" name="sku" value="{{ old('sku') }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Stok</label><input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" class="w-full border rounded-lg px-4 py-2"></div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Durum</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-purple-600">Aktif</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded text-purple-600">One Cikan</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }} class="rounded text-purple-600">Yeni Urun</label>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700">Kaydet</button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-gray-200 rounded-lg hover:bg-gray-300">Iptal</a>
            </div>
        </div>
    </div>
</form>
@endsection
