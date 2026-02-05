@props(['products', 'title' => null, 'subtitle' => null, 'viewAllLink' => null])

@if($products && $products->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        @if($title)
            <div class="flex items-end justify-between mb-10">
                <div>
                    @if($subtitle)
                        <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">{{ $subtitle }}</p>
                    @endif
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-black">{{ $title }}</h2>
                </div>
                @if($viewAllLink)
                    <a href="{{ $viewAllLink }}" class="hidden md:inline-flex items-center text-sm uppercase tracking-wider text-black hover:text-gray-600 transition-colors">
                        Tumunu Gor
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        @endif

        <div x-data="productCarousel()" class="relative">
            <!-- Products Container -->
            <div class="overflow-hidden" x-ref="container">
                <div class="flex transition-transform duration-500 ease-out"
                     :style="{ transform: `translateX(-${currentIndex * (100 / visibleSlides)}%)` }">
                    @foreach($products as $product)
                        <div class="flex-none w-1/2 md:w-1/3 lg:w-1/4 px-2">
                            <x-product-card-minimal :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Arrows -->
            @if($products->count() > 4)
                <button @click="prev()"
                        :class="currentIndex === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-black hover:text-white'"
                        class="absolute -left-4 md:-left-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white border border-black text-black flex items-center justify-center transition-all z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="next()"
                        :class="currentIndex >= maxIndex ? 'opacity-30 cursor-not-allowed' : 'hover:bg-black hover:text-white'"
                        class="absolute -right-4 md:-right-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white border border-black text-black flex items-center justify-center transition-all z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            @endif
        </div>

        @if($viewAllLink)
            <div class="text-center mt-10 md:hidden">
                <a href="{{ $viewAllLink }}"
                   class="inline-block px-8 py-3 border-2 border-black text-black uppercase text-sm tracking-wider hover:bg-black hover:text-white transition-all duration-300">
                    Tumunu Gor
                </a>
            </div>
        @endif
    </div>
</section>

<script>
function productCarousel() {
    return {
        currentIndex: 0,
        totalSlides: {{ $products->count() }},
        visibleSlides: 4,
        get maxIndex() {
            return Math.max(0, this.totalSlides - this.visibleSlides);
        },
        init() {
            this.updateVisibleSlides();
            window.addEventListener('resize', () => this.updateVisibleSlides());
        },
        updateVisibleSlides() {
            if (window.innerWidth < 768) {
                this.visibleSlides = 2;
            } else if (window.innerWidth < 1024) {
                this.visibleSlides = 3;
            } else {
                this.visibleSlides = 4;
            }
            if (this.currentIndex > this.maxIndex) {
                this.currentIndex = this.maxIndex;
            }
        },
        next() {
            if (this.currentIndex < this.maxIndex) {
                this.currentIndex++;
            }
        },
        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            }
        }
    }
}
</script>
@endif
