@extends('layouts.admin')
@section('title', 'Urun Duzenle')
@section('content')
<div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">Urun Duzenle: {{ $product->name }}</h2></div>
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Temel Bilgiler</h3>
                <div class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Urun Adi *</label><input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label><select name="category_id" required class="w-full border rounded-lg px-4 py-2"><option value="">Secin</option>@foreach($categories as $cat)<optgroup label="{{ $cat->name }}">@foreach($cat->children as $child)<option value="{{ $child->id }}" {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>@endforeach @if($cat->children->isEmpty())<option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endif</optgroup>@endforeach</select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Kisa Aciklama</label><textarea name="short_description" rows="2" class="w-full border rounded-lg px-4 py-2">{{ old('short_description', $product->short_description) }}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Aciklama</label><textarea name="description" rows="5" class="w-full border rounded-lg px-4 py-2">{{ old('description', $product->description) }}</textarea></div>
                </div>
            </div>

            <!-- Existing Images -->
            @if($product->images->count() > 0)
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Mevcut Gorseller</h3>
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-24 object-cover rounded {{ $image->is_primary ? 'ring-2 ring-purple-600' : '' }}">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                @unless($image->is_primary)<form action="{{ route('admin.products.set-primary-image', $image) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="text-white"><i class="fas fa-star"></i></button></form>@endunless
                                <form action="{{ route('admin.products.delete-image', $image) }}" method="POST" onsubmit="return confirm('Silmek istediginize emin misiniz?')">@csrf @method('DELETE')<button type="submit" class="text-white"><i class="fas fa-trash"></i></button></form>
                            </div>
                            @if($image->is_primary)<span class="absolute top-1 left-1 bg-purple-600 text-white text-xs px-1 rounded">Ana</span>@endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Yeni Gorsel Ekle</h3>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border rounded-lg px-4 py-2">
            </div>

            <!-- Specifications -->
            <div class="bg-white rounded-lg p-6" x-data="{ specs: {{ json_encode($product->specifications->map(fn($s) => ['key' => $s->key, 'value' => $s->value, 'unit' => $s->unit])->toArray() ?: [['key' => '', 'value' => '', 'unit' => '']]) }} }">
                <h3 class="font-semibold mb-4">Ozellikler</h3>
                <template x-for="(spec, index) in specs" :key="index">
                    <div class="grid grid-cols-4 gap-2 mb-2">
                        <input type="text" :name="'specifications['+index+'][key]'" x-model="spec.key" placeholder="Ozellik" class="border rounded px-3 py-2">
                        <input type="text" :name="'specifications['+index+'][value]'" x-model="spec.value" placeholder="Deger" class="border rounded px-3 py-2">
                        <input type="text" :name="'specifications['+index+'][unit]'" x-model="spec.unit" placeholder="Birim" class="border rounded px-3 py-2">
                        <button type="button" @click="specs.splice(index, 1)" class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </template>
                <button type="button" @click="specs.push({ key: '', value: '', unit: '' })" class="text-purple-600 text-sm"><i class="fas fa-plus mr-1"></i>Ekle</button>
            </div>

            <!-- Features -->
            <div class="bg-white rounded-lg p-6" x-data="{ features: {{ json_encode($product->features->pluck('feature')->toArray() ?: ['']) }} }">
                <h3 class="font-semibold mb-4">Ozellikler (Liste)</h3>
                <template x-for="(feature, index) in features" :key="index">
                    <div class="flex gap-2 mb-2"><input type="text" :name="'features['+index+']'" x-model="features[index]" placeholder="Ozellik" class="flex-1 border rounded px-3 py-2"><button type="button" @click="features.splice(index, 1)" class="text-red-500"><i class="fas fa-trash"></i></button></div>
                </template>
                <button type="button" @click="features.push('')" class="text-purple-600 text-sm"><i class="fas fa-plus mr-1"></i>Ekle</button>
            </div>

            <!-- Variants -->
            <div class="bg-white rounded-lg p-6" x-data="{ variants: {{ json_encode($product->variants->map(fn($v) => ['id' => $v->id, 'name' => $v->name, 'sku' => $v->sku, 'price_difference' => $v->price_difference, 'stock' => $v->stock, 'is_active' => $v->is_active])->toArray() ?: []) }} }">
                <h3 class="font-semibold mb-4">Varyantlar</h3>
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="grid grid-cols-6 gap-2 mb-2">
                        <input type="hidden" :name="'variants['+index+'][id]'" x-model="variant.id">
                        <input type="text" :name="'variants['+index+'][name]'" x-model="variant.name" placeholder="Ad" class="border rounded px-3 py-2">
                        <input type="text" :name="'variants['+index+'][sku]'" x-model="variant.sku" placeholder="SKU" class="border rounded px-3 py-2">
                        <input type="number" :name="'variants['+index+'][price_difference]'" x-model="variant.price_difference" placeholder="Fiyat Farki" step="0.01" class="border rounded px-3 py-2">
                        <input type="number" :name="'variants['+index+'][stock]'" x-model="variant.stock" placeholder="Stok" min="0" class="border rounded px-3 py-2">
                        <button type="button" @click="variants.splice(index, 1)" class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </template>
                <button type="button" @click="variants.push({ id: null, name: '', sku: '', price_difference: 0, stock: 0, is_active: true })" class="text-purple-600 text-sm"><i class="fas fa-plus mr-1"></i>Varyant Ekle</button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Fiyat & Stok</h3>
                <div class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Fiyat (TL) *</label><input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Indirimli Fiyat</label><input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">SKU</label><input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Stok</label><input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full border rounded-lg px-4 py-2"></div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold mb-4">Durum</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded text-purple-600">Aktif</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded text-purple-600">One Cikan</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }} class="rounded text-purple-600">Yeni Urun</label>
                </div>
            </div>
            <div class="flex gap-3"><button type="submit" class="flex-1 bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700">Guncelle</button><a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-gray-200 rounded-lg hover:bg-gray-300">Iptal</a></div>
        </div>
    </div>
</form>
@endsection
