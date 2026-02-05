@props(['sliders'])

@if($sliders && $sliders->count() > 0)
<div class="relative" x-data="heroSlider()" x-init="init()">
    <!-- Slides -->
    <div class="relative h-[500px] md:h-[600px] lg:h-[700px] overflow-hidden">
        @foreach($sliders as $index => $slider)
            <div x-show="currentSlide === {{ $index }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                <!-- Background Image -->
                <picture>
                    @if($slider->image_mobile)
                        <source media="(max-width: 768px)" srcset="{{ $slider->mobile_image_url }}">
                    @endif
                    <img src="{{ $slider->image_url }}"
                         alt="{{ $slider->title }}"
                         class="w-full h-full object-cover">
                </picture>

                <!-- Overlay -->
                @if($slider->overlay_color)
                    <div class="absolute inset-0" style="background-color: {{ $slider->overlay_color }}"></div>
                @endif

                <!-- Content -->
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-4">
                        <div class="max-w-2xl {{ $slider->text_position === 'center' ? 'mx-auto text-center' : ($slider->text_position === 'right' ? 'ml-auto text-right' : '') }}">
                            @if($slider->subtitle)
                                <p class="text-sm md:text-base uppercase tracking-widest mb-3 opacity-90"
                                   style="color: {{ $slider->text_color }}">
                                    {{ $slider->subtitle }}
                                </p>
                            @endif

                            @if($slider->title)
                                <h2 class="text-3xl md:text-5xl lg:text-6xl font-serif font-bold mb-4"
                                    style="color: {{ $slider->text_color }}">
                                    {{ $slider->title }}
                                </h2>
                            @endif

                            @if($slider->description)
                                <p class="text-base md:text-lg mb-6 opacity-90"
                                   style="color: {{ $slider->text_color }}">
                                    {{ $slider->description }}
                                </p>
                            @endif

                            @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}"
                                   class="inline-block px-8 py-3 text-sm uppercase tracking-wider transition-all duration-300
                                   {{ $slider->button_style === 'primary' ? 'bg-black text-white hover:bg-gray-800' : '' }}
                                   {{ $slider->button_style === 'secondary' ? 'bg-white text-black hover:bg-gray-100' : '' }}
                                   {{ $slider->button_style === 'outline' ? 'border-2 border-white text-white hover:bg-white hover:text-black' : '' }}">
                                    {{ $slider->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation Arrows -->
    @if($sliders->count() > 1)
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/80 hover:bg-white text-black flex items-center justify-center transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/80 hover:bg-white text-black flex items-center justify-center transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
            @foreach($sliders as $index => $slider)
                <button @click="goTo({{ $index }})"
                        :class="currentSlide === {{ $index }} ? 'bg-black w-8' : 'bg-black/30 w-2'"
                        class="h-2 rounded-full transition-all duration-300">
                </button>
            @endforeach
        </div>
    @endif
</div>

<script>
function heroSlider() {
    return {
        currentSlide: 0,
        totalSlides: {{ $sliders->count() }},
        autoplayInterval: null,
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.autoplayInterval = setInterval(() => this.next(), 5000);
        },
        stopAutoplay() {
            clearInterval(this.autoplayInterval);
        },
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        goTo(index) {
            this.currentSlide = index;
            this.stopAutoplay();
            this.startAutoplay();
        }
    }
}
</script>
@endif
