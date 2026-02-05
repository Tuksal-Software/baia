@props(['product', 'showCategory' => true])

<article class="group relative bg-white">
    <!-- Image Container -->
    <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden aspect-[3/4]">
        @if($product->primaryImage)
            <img src="{{ $product->primaryImage->image_url }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                 loading="lazy">
        @else
            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        <!-- Overlay on hover -->
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($product->is_on_sale)
                <span class="bg-black text-white text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1">
                    -{{ $product->discount_percentage }}%
                </span>
            @endif
            @if($product->is_new)
                <span class="bg-white text-black text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 border border-black">
                    Yeni
                </span>
            @endif
        </div>

        <!-- Out of Stock Overlay -->
        @unless($product->is_in_stock)
            <div class="absolute inset-0 bg-white/80 flex items-center justify-center">
                <span class="text-sm font-medium uppercase tracking-wider text-gray-600">Tukendi</span>
            </div>
        @endunless

        <!-- Quick Add Button (on hover) -->
        @if($product->is_in_stock)
            <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit"
                            class="w-full bg-black text-white py-3 text-xs font-semibold uppercase tracking-wider hover:bg-gray-900 transition-colors">
                        Sepete Ekle
                    </button>
                </form>
            </div>
        @endif
    </a>

    <!-- Product Info -->
    <div class="pt-4 pb-2">
        @if($showCategory && $product->category)
            <a href="{{ route('categories.show', $product->category) }}"
               class="text-[11px] text-gray-500 uppercase tracking-wider hover:text-black transition-colors">
                {{ $product->category->name }}
            </a>
        @endif

        <h3 class="mt-1.5">
            <a href="{{ route('products.show', $product) }}"
               class="font-serif text-base text-gray-900 hover:text-gray-600 transition-colors line-clamp-2 leading-snug">
                {{ $product->name }}
            </a>
        </h3>

        <!-- Rating -->
        @if($product->reviews_count > 0)
            <div class="flex items-center gap-1.5 mt-2">
                <div class="flex gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $product->rating)
                            <svg class="w-3.5 h-3.5 text-black" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="text-[11px] text-gray-400">({{ $product->reviews_count }})</span>
            </div>
        @endif

        <!-- Price -->
        <div class="mt-3 flex items-baseline gap-2">
            @if($product->is_on_sale)
                <span class="text-base font-medium text-black">
                    {{ number_format($product->sale_price, 2, ',', '.') }} TL
                </span>
                <span class="text-sm text-gray-400 line-through">
                    {{ number_format($product->price, 2, ',', '.') }} TL
                </span>
            @else
                <span class="text-base font-medium text-black">
                    {{ number_format($product->price, 2, ',', '.') }} TL
                </span>
            @endif
        </div>
    </div>
</article>
