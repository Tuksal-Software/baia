@props(['product'])

<article class="group">
    <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-[3/4] overflow-hidden mb-4 bg-gray-50">
        @php
            $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
            $secondaryImage = $product->images->where('is_primary', false)->first();
        @endphp

        @if($primaryImage)
            <img src="{{ $primaryImage->image_url }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-all duration-700 ease-out {{ $secondaryImage ? 'group-hover:opacity-0' : 'group-hover:scale-105' }}"
                 loading="lazy">
            @if($secondaryImage)
                <img src="{{ $secondaryImage->image_url }}"
                     alt="{{ $product->name }}"
                     class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-700"
                     loading="lazy">
            @endif
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            @if($product->is_new)
                <span class="bg-white text-black text-[10px] font-semibold px-2.5 py-1 uppercase tracking-wider border border-black">
                    {{ __('New') }}
                </span>
            @endif
            @if($product->sale_price)
                <span class="bg-black text-white text-[10px] font-semibold px-2.5 py-1 uppercase tracking-wider">
                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                </span>
            @endif
        </div>

        <!-- Quick Add Button -->
        @if($product->stock > 0)
            <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                            class="w-full bg-black text-white py-2.5 text-xs font-semibold uppercase tracking-wider hover:bg-gray-900 transition-colors">
                        {{ __('Add to Cart') }}
                    </button>
                </form>
            </div>
        @else
            <div class="absolute inset-0 bg-white/70 flex items-center justify-center">
                <span class="text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Sold Out') }}</span>
            </div>
        @endif
    </a>

    <!-- Product Info -->
    <div class="text-center">
        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h3 class="font-serif text-sm text-gray-900 group-hover:text-gray-600 transition-colors line-clamp-2 leading-snug">
                {{ $product->name }}
            </h3>
        </a>
        <div class="flex items-center justify-center gap-2 mt-2">
            @if($product->sale_price)
                <span class="text-sm font-medium text-black">
                    {{ number_format($product->sale_price, 2, ',', '.') }} TL
                </span>
                <span class="text-xs text-gray-400 line-through">
                    {{ number_format($product->price, 2, ',', '.') }} TL
                </span>
            @else
                <span class="text-sm font-medium text-black">
                    {{ number_format($product->price, 2, ',', '.') }} TL
                </span>
            @endif
        </div>
    </div>
</article>
