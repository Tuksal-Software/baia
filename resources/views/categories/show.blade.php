@extends('layouts.app')
@section('title', $category->name)
@section('content')
<div class="container mx-auto px-4 py-8">
    <nav class="text-sm mb-6"><ol class="flex items-center gap-2 text-gray-600"><li><a href="{{ route('home') }}" class="hover:text-purple-600">Ana Sayfa</a></li><li>/</li><li><a href="{{ route('categories.index') }}" class="hover:text-purple-600">Kategoriler</a></li><li>/</li><li class="text-gray-800">{{ $category->name }}</li></ol></nav>
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <aside class="lg:w-64 flex-shrink-0">
            @if($subcategories->count() > 0)
                <div class="bg-white rounded-lg p-4 mb-4">
                    <h3 class="font-semibold mb-3">Alt Kategoriler</h3>
                    <ul class="space-y-2">@foreach($subcategories as $sub)<li><a href="{{ route('categories.show', $sub) }}" class="text-gray-600 hover:text-purple-600 flex justify-between"><span>{{ $sub->name }}</span><span class="text-gray-400">({{ $sub->products_count }})</span></a></li>@endforeach</ul>
                </div>
            @endif
            <form method="GET" class="bg-white rounded-lg p-4">
                <h3 class="font-semibold mb-3">Filtrele</h3>
                @if($priceRange)<div class="mb-4"><label class="text-sm text-gray-600">Fiyat Araligi</label><div class="flex gap-2 mt-1"><input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-full border rounded px-2 py-1 text-sm"><input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-full border rounded px-2 py-1 text-sm"></div></div>@endif
                <div class="space-y-2 mb-4"><label class="flex items-center gap-2"><input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }} class="rounded text-purple-600">Indirimde</label><label class="flex items-center gap-2"><input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="rounded text-purple-600">Stokta</label></div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700">Uygula</button>
            </form>
        </aside>

        <!-- Products -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h1>
                <select onchange="window.location.href=this.value" class="border rounded-lg px-3 py-2 text-sm">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>En Yeni</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Fiyat (Dusuk-Yuksek)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Fiyat (Yuksek-Dusuk)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" {{ request('sort') == 'rating' ? 'selected' : '' }}>Puan</option>
                </select>
            </div>
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">@foreach($products as $product)<x-product-card :product="$product" />@endforeach</div>
                <div class="mt-8">{{ $products->links() }}</div>
            @else
                <div class="text-center py-12 bg-white rounded-lg"><i class="fas fa-search text-4xl text-gray-400 mb-4"></i><p class="text-gray-600">Bu kriterlere uygun urun bulunamadi.</p></div>
            @endif
        </div>
    </div>
</div>
@endsection
