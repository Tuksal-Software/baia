@extends('layouts.admin')
@section('title', 'Urunler')
@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-xl font-semibold">Urunler</h2>
    <a href="{{ route('admin.products.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-plus mr-2"></i>Yeni Urun</a>
</div>

<!-- Filters -->
<form method="GET" class="bg-white rounded-lg p-4 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Urun ara..." class="border rounded-lg px-3 py-2">
        <select name="category_id" class="border rounded-lg px-3 py-2"><option value="">Tum Kategoriler</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach</select>
        <select name="status" class="border rounded-lg px-3 py-2"><option value="">Tum Durumlar</option><option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Pasif</option><option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>One Cikan</option><option value="on_sale" {{ request('status') == 'on_sale' ? 'selected' : '' }}>Indirimde</option><option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Dusuk Stok</option></select>
        <button type="submit" class="bg-gray-800 text-white rounded-lg hover:bg-gray-900">Filtrele</button>
    </div>
</form>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Urun</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Kategori</th><th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Fiyat</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Stok</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th><th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th></tr></thead>
        <tbody class="divide-y">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><div class="flex items-center gap-3">@if($product->primaryImage)<img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-12 h-12 rounded object-cover">@else<div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center"><i class="fas fa-image text-gray-400"></i></div>@endif<div><p class="font-medium">{{ Str::limit($product->name, 40) }}</p><p class="text-xs text-gray-500">SKU: {{ $product->sku ?? '-' }}</p></div></div></td>
                    <td class="px-4 py-3 text-gray-600">{{ $product->category->name }}</td>
                    <td class="px-4 py-3 text-right">@if($product->sale_price)<span class="text-red-600 font-semibold">{{ number_format($product->sale_price, 2) }}</span><br><span class="text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>@else<span class="font-semibold">{{ number_format($product->price, 2) }}</span>@endif TL</td>
                    <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded text-xs {{ $product->stock <= 5 ? ($product->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') : 'bg-green-100 text-green-700' }}">{{ $product->stock }}</span></td>
                    <td class="px-4 py-3 text-center"><div class="flex flex-col items-center gap-1"><form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="px-2 py-1 rounded text-xs {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $product->is_active ? 'Aktif' : 'Pasif' }}</button></form>@if($product->is_featured)<span class="text-xs text-purple-600"><i class="fas fa-star"></i></span>@endif</div></td>
                    <td class="px-4 py-3 text-right whitespace-nowrap"><a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-edit"></i></a><a href="{{ route('products.show', $product) }}" target="_blank" class="text-gray-600 hover:text-gray-800 mr-2"><i class="fas fa-external-link-alt"></i></a><form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button></form></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Urun bulunamadi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
