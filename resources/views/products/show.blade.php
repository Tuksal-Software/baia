@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6">
        <ol class="flex items-center gap-2 text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-purple-600">{{ __('Home') }}</a></li>
            <li>/</li>
            <li><a href="{{ route('categories.show', $product->category) }}" class="hover:text-purple-600">{{ $product->category->name }}</a></li>
            <li>/</li>
            <li class="text-gray-800">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Images -->
        <div x-data="{ activeImage: 0 }">
            <div class="bg-white rounded-lg overflow-hidden mb-4">
                @if($product->images->count() > 0)
                    @foreach($product->images as $index => $image)
                        <img x-show="activeImage === {{ $index }}" src="{{ $image->image_url }}" alt="{{ $product->name }}" class="w-full h-96 object-contain">
                    @endforeach
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center"><i class="fas fa-image text-6xl text-gray-400"></i></div>
                @endif
            </div>
            @if($product->images->count() > 1)
                <div class="grid grid-cols-5 gap-2">
                    @foreach($product->images as $index => $image)
                        <button @click="activeImage = {{ $index }}" :class="activeImage === {{ $index }} ? 'ring-2 ring-purple-600' : ''" class="rounded-lg overflow-hidden">
                            <img src="{{ $image->image_url }}" alt="" class="w-full h-20 object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
            @if($product->reviews_count > 0)
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex text-yellow-400">@for($i = 1; $i <= 5; $i++)<i class="{{ $i <= $product->rating ? 'fas' : 'far' }} fa-star"></i>@endfor</div>
                    <span class="text-gray-600">({{ $product->reviews_count }} {{ __('reviews') }})</span>
                </div>
            @endif

            <div class="mb-6">
                @if($product->is_on_sale)
                    <span class="text-3xl font-bold text-red-600">{{ number_format($product->sale_price, 2) }} {{ __('TL') }}</span>
                    <span class="text-xl text-gray-400 line-through ml-2">{{ number_format($product->price, 2) }} {{ __('TL') }}</span>
                    <span class="bg-red-100 text-red-600 text-sm px-2 py-1 rounded ml-2">%{{ $product->discount_percentage }} {{ __('Discount') }}</span>
                @else
                    <span class="text-3xl font-bold text-gray-800">{{ number_format($product->price, 2) }} {{ __('TL') }}</span>
                @endif
            </div>

            @if($product->short_description)
                <p class="text-gray-600 mb-6">{{ $product->short_description }}</p>
            @endif

            <!-- Variants -->
            @if($product->variants->count() > 0)
                <div class="mb-6" x-data="{ selectedVariant: null }">
                    <h3 class="font-semibold text-gray-800 mb-2">{{ __('Select Variant') }}:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->variants as $variant)
                            <label class="cursor-pointer">
                                <input type="radio" name="variant_id" value="{{ $variant->id }}" class="hidden peer" x-model="selectedVariant">
                                <span class="block px-4 py-2 border rounded-lg peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600 hover:border-purple-400">
                                    {{ $variant->name }}
                                    @if($variant->price_difference != 0)
                                        <span class="text-sm">({{ $variant->price_difference > 0 ? '+' : '' }}{{ number_format($variant->price_difference, 2) }} {{ __('TL') }})</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Add to Cart -->
            @if($product->is_in_stock)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex gap-4">
                        <div class="flex items-center border rounded-lg">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-4 py-2 text-gray-600 hover:bg-gray-100">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="99" class="w-16 text-center border-0 focus:ring-0">
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-4 py-2 text-gray-600 hover:bg-gray-100">+</button>
                        </div>
                        <button type="submit" class="flex-1 bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                            <i class="fas fa-cart-plus mr-2"></i>{{ __('Add to Cart') }}
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-red-100 text-red-600 p-4 rounded-lg mb-6"><i class="fas fa-exclamation-circle mr-2"></i>{{ __('This product is currently out of stock.') }}</div>
            @endif

            <!-- Specifications -->
            @if($product->specifications->count() > 0)
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">{{ __('Product Specifications') }}</h3>
                    <table class="w-full text-sm">
                        @foreach($product->specifications as $spec)
                            <tr class="border-b"><td class="py-2 text-gray-600">{{ $spec->key }}</td><td class="py-2 text-gray-800">{{ $spec->formatted_value }}</td></tr>
                        @endforeach
                    </table>
                </div>
            @endif

            <!-- Features -->
            @if($product->features->count() > 0)
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">{{ __('Features') }}</h3>
                    <ul class="space-y-2">
                        @foreach($product->features as $feature)
                            <li class="flex items-center gap-2 text-gray-600"><i class="fas fa-check text-green-500"></i>{{ $feature->feature }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Description -->
    @if($product->description)
        <div class="mt-12 bg-white rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __('Product Description') }}</h2>
            <div class="prose max-w-none text-gray-600">{!! nl2br(e($product->description)) !!}</div>
        </div>
    @endif

    <!-- Reviews -->
    <div class="mt-12 bg-white rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">{{ __('Customer Reviews') }} ({{ $product->reviews_count }})</h2>
        @if($product->approvedReviews->count() > 0)
            <div class="space-y-4 mb-8">
                @foreach($product->approvedReviews as $review)
                    <div class="border-b pb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400 text-sm">@for($i = 1; $i <= 5; $i++)<i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>@endfor</div>
                            <span class="font-semibold">{{ $review->customer_name }}</span>
                            @if($review->is_verified)<span class="text-green-600 text-xs"><i class="fas fa-check-circle"></i> {{ __('Verified') }}</span>@endif
                        </div>
                        @if($review->comment)<p class="text-gray-600">{{ $review->comment }}</p>@endif
                        <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->format('d.m.Y') }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Review Form -->
        <div class="border-t pt-6">
            <h3 class="font-semibold text-gray-800 mb-4">{{ __('Write a Review') }}</h3>
            <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="customer_name" placeholder="{{ __('Your Name') }}" required class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                    <input type="email" name="customer_email" placeholder="{{ __('Email') }}" required class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div><label class="block text-sm text-gray-600 mb-1">{{ __('Your Rating') }}</label><select name="rating" required class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"><option value="5">{{ __('5 Stars') }}</option><option value="4">{{ __('4 Stars') }}</option><option value="3">{{ __('3 Stars') }}</option><option value="2">{{ __('2 Stars') }}</option><option value="1">{{ __('1 Star') }}</option></select></div>
                <textarea name="comment" rows="4" placeholder="{{ __('Your comment (optional)') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></textarea>
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-800 mb-6">{{ __('Similar Products') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
