@props(['product'])

<div class="group">
    <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-[3/4] overflow-hidden mb-4 bg-gray-100">
        @php
            $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
            $secondaryImage = $product->images->where('is_primary', false)->first();
        @endphp

        @if($primaryImage)
            <img src="{{ asset('storage/' . $primaryImage->image_path) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-opacity duration-500 {{ $secondaryImage ? 'group-hover:opacity-0' : '' }}">
            @if($secondaryImage)
                <img src="{{ asset('storage/' . $secondaryImage->image_path) }}"
                     alt="{{ $product->name }}"
                     class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            @endif
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($product->is_new)
                <span class="bg-black text-white text-xs px-3 py-1 uppercase tracking-wider">Yeni</span>
            @endif
            @if($product->sale_price)
                <span class="bg-red-600 text-white text-xs px-3 py-1 uppercase tracking-wider">
                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                </span>
            @endif
        </div>

        <!-- Quick Add Button (Desktop) -->
        <div class="absolute bottom-0 left-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="w-full bg-white text-black py-3 text-sm uppercase tracking-wider hover:bg-black hover:text-white transition-all duration-300">
                    Sepete Ekle
                </button>
            </form>
        </div>
    </a>

    <div class="text-center">
        <a href="{{ route('products.show', $product->slug) }}" class="block mb-2">
            <h3 class="text-sm font-medium text-gray-800 group-hover:text-black transition-colors">{{ $product->name }}</h3>
        </a>
        <div class="flex items-center justify-center gap-2">
            @if($product->sale_price)
                <span class="text-red-600 font-medium">{{ number_format($product->sale_price, 2, ',', '.') }} {{ $siteSettings['currency_symbol'] ?? '₺' }}</span>
                <span class="text-gray-400 line-through text-sm">{{ number_format($product->price, 2, ',', '.') }} {{ $siteSettings['currency_symbol'] ?? '₺' }}</span>
            @else
                <span class="text-gray-800 font-medium">{{ number_format($product->price, 2, ',', '.') }} {{ $siteSettings['currency_symbol'] ?? '₺' }}</span>
            @endif
        </div>
    </div>
</div>
