@props(['product'])
<div class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden group">
    <a href="{{ route('products.show', $product) }}" class="block relative">
        @if($product->primaryImage)
            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 sm:h-56 object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-48 sm:h-56 bg-gray-200 flex items-center justify-center"><i class="fas fa-image text-4xl text-gray-400"></i></div>
        @endif
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            @if($product->is_on_sale)<span class="bg-red-500 text-white text-xs px-2 py-1 rounded">%{{ $product->discount_percentage }} Indirim</span>@endif
            @if($product->is_new)<span class="bg-green-500 text-white text-xs px-2 py-1 rounded">Yeni</span>@endif
            @if($product->is_featured)<span class="bg-purple-500 text-white text-xs px-2 py-1 rounded">One Cikan</span>@endif
        </div>
        @unless($product->is_in_stock)<div class="absolute inset-0 bg-black/50 flex items-center justify-center"><span class="bg-white text-gray-800 px-4 py-2 rounded font-semibold">Tukendi</span></div>@endunless
    </a>
    <div class="p-4">
        <a href="{{ route('categories.show', $product->category) }}" class="text-xs text-purple-600 hover:underline">{{ $product->category->name }}</a>
        <h3 class="mt-1"><a href="{{ route('products.show', $product) }}" class="font-semibold text-gray-800 hover:text-purple-600 line-clamp-2">{{ $product->name }}</a></h3>
        @if($product->reviews_count > 0)
            <div class="flex items-center gap-1 mt-2">
                <div class="flex text-yellow-400 text-sm">@for($i = 1; $i <= 5; $i++)@if($i <= $product->rating)<i class="fas fa-star"></i>@elseif($i - 0.5 <= $product->rating)<i class="fas fa-star-half-alt"></i>@else<i class="far fa-star"></i>@endif @endfor</div>
                <span class="text-xs text-gray-500">({{ $product->reviews_count }})</span>
            </div>
        @endif
        <div class="mt-3 flex items-center justify-between">
            <div>
                @if($product->is_on_sale)
                    <span class="text-lg font-bold text-red-600">{{ number_format($product->sale_price, 2) }} TL</span>
                    <span class="text-sm text-gray-400 line-through ml-1">{{ number_format($product->price, 2) }} TL</span>
                @else
                    <span class="text-lg font-bold text-gray-800">{{ number_format($product->price, 2) }} TL</span>
                @endif
            </div>
        </div>
        @if($product->is_in_stock)
            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition text-sm"><i class="fas fa-cart-plus mr-1"></i> Sepete Ekle</button></form>
        @endif
    </div>
</div>
