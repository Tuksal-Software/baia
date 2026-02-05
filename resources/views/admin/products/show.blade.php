@extends('layouts.admin')
@section('title', 'Urun Detay')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-2"><a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">{{ $product->name }}</h2></div>
    <div class="flex gap-2"><a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-edit mr-2"></i>Duzenle</a><a href="{{ route('products.show', $product) }}" target="_blank" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-external-link-alt mr-2"></i>Sitede Gor</a></div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Images -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Gorseller</h3>
            @if($product->images->count() > 0)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-24 object-cover rounded {{ $image->is_primary ? 'ring-2 ring-purple-600' : '' }}">
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Gorsel yok</p>
            @endif
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Aciklama</h3>
            @if($product->short_description)<p class="text-gray-600 mb-4">{{ $product->short_description }}</p>@endif
            @if($product->description)<div class="prose max-w-none text-gray-600">{!! nl2br(e($product->description)) !!}</div>@else<p class="text-gray-500">Aciklama yok</p>@endif
        </div>

        <!-- Specifications -->
        @if($product->specifications->count() > 0)
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Ozellikler</h3>
            <table class="w-full text-sm">@foreach($product->specifications as $spec)<tr class="border-b"><td class="py-2 text-gray-600">{{ $spec->key }}</td><td class="py-2">{{ $spec->formatted_value }}</td></tr>@endforeach</table>
        </div>
        @endif

        <!-- Features -->
        @if($product->features->count() > 0)
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Ozellikler (Liste)</h3>
            <ul class="space-y-1">@foreach($product->features as $feature)<li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i>{{ $feature->feature }}</li>@endforeach</ul>
        </div>
        @endif

        <!-- Reviews -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Yorumlar ({{ $product->reviews_count }})</h3>
            @if($product->reviews->count() > 0)
                <div class="space-y-3">
                    @foreach($product->reviews as $review)
                        <div class="p-3 bg-gray-50 rounded">
                            <div class="flex justify-between items-start"><div><div class="flex text-yellow-400 text-sm">@for($i = 1; $i <= 5; $i++)<i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>@endfor</div><p class="font-medium">{{ $review->customer_name }}</p></div><span class="text-xs px-2 py-1 rounded {{ $review->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $review->is_approved ? 'Onaylandi' : 'Bekliyor' }}</span></div>
                            @if($review->comment)<p class="text-sm text-gray-600 mt-2">{{ $review->comment }}</p>@endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Henuz yorum yok</p>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <!-- Info Card -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Bilgiler</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Kategori</span><span>{{ $product->category->name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">SKU</span><span>{{ $product->sku ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Fiyat</span><span class="font-semibold">{{ number_format($product->price, 2) }} TL</span></div>
                @if($product->sale_price)<div class="flex justify-between"><span class="text-gray-500">Indirimli Fiyat</span><span class="font-semibold text-red-600">{{ number_format($product->sale_price, 2) }} TL</span></div>@endif
                <div class="flex justify-between"><span class="text-gray-500">Stok</span><span class="px-2 py-1 rounded text-xs {{ $product->stock <= 5 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">{{ $product->stock }} adet</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Puan</span><span>{{ $product->rating }}/5 ({{ $product->reviews_count }})</span></div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Durum</h3>
            <div class="space-y-2">
                <div class="flex items-center gap-2">@if($product->is_active)<i class="fas fa-check-circle text-green-500"></i><span>Aktif</span>@else<i class="fas fa-times-circle text-red-500"></i><span>Pasif</span>@endif</div>
                @if($product->is_featured)<div class="flex items-center gap-2"><i class="fas fa-star text-purple-500"></i><span>One Cikan</span></div>@endif
                @if($product->is_new)<div class="flex items-center gap-2"><i class="fas fa-sparkles text-green-500"></i><span>Yeni Urun</span></div>@endif
                @if($product->is_on_sale)<div class="flex items-center gap-2"><i class="fas fa-tags text-red-500"></i><span>Indirimde (%{{ $product->discount_percentage }})</span></div>@endif
            </div>
        </div>

        <!-- Variants -->
        @if($product->variants->count() > 0)
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Varyantlar ({{ $product->variants->count() }})</h3>
            <div class="space-y-2">
                @foreach($product->variants as $variant)
                    <div class="p-2 bg-gray-50 rounded text-sm">
                        <p class="font-medium">{{ $variant->name }}</p>
                        <p class="text-gray-500">Stok: {{ $variant->stock }} | Fiyat: {{ $variant->price_difference >= 0 ? '+' : '' }}{{ number_format($variant->price_difference, 2) }} TL</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Dates -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Tarihler</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Olusturulma</span><span>{{ $product->created_at->format('d.m.Y H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Guncelleme</span><span>{{ $product->updated_at->format('d.m.Y H:i') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
