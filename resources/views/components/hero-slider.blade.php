@props(['sliders'])

@if($sliders && $sliders->count() > 0)
<section class="relative w-full" x-data="heroSlider({{ $sliders->count() }})" x-init="init()">
    <!-- Slides Container -->
    <div class="relative h-[60vh] md:h-[75vh] lg:h-[85vh] overflow-hidden bg-gray-100">
        @foreach($sliders as $index => $slider)
            <div x-show="currentSlide === {{ $index }}"
                 x-transition:enter="transition-opacity ease-out duration-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-700"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0"
                 style="display: none;"
                 :style="currentSlide === {{ $index }} ? 'display: block;' : ''">

                <!-- Background Image with Ken Burns Effect -->
                <div class="absolute inset-0 overflow-hidden">
                    <picture>
                        @if($slider->image_mobile)
                            <source media="(max-width: 768px)" srcset="{{ $slider->mobile_image_url }}">
                        @endif
                        <img src="{{ $slider->image_url }}"
                             alt="{{ $slider->title ?? 'Slider' }}"
                             class="w-full h-full object-cover transition-transform duration-[10000ms] ease-out"
                             :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'"
                             loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                    </picture>
                </div>

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent"></div>

                @if($slider->overlay_color)
                    <div class="absolute inset-0" style="background-color: {{ $slider->overlay_color }}"></div>
                @endif

                <!-- Content -->
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full max-w-7xl mx-auto px-6 lg:px-8">
                        <div class="max-w-2xl {{ $slider->text_position === 'center' ? 'mx-auto text-center' : ($slider->text_position === 'right' ? 'ml-auto text-right' : '') }}"
                             x-show="currentSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-700 delay-300"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0">

                            @if($slider->subtitle)
                                <p class="text-xs md:text-sm uppercase tracking-[0.3em] mb-4 font-medium"
                                   style="color: {{ $slider->text_color ?? '#ffffff' }}">
                                    {{ $slider->subtitle }}
                                </p>
                            @endif

                            @if($slider->title)
                                <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-medium leading-[1.1] mb-6"
                                    style="color: {{ $slider->text_color ?? '#ffffff' }}">
                                    {{ $slider->title }}
                                </h1>
                            @endif

                            @if($slider->description)
                                <p class="text-base md:text-lg leading-relaxed mb-8 max-w-lg {{ $slider->text_position === 'center' ? 'mx-auto' : ($slider->text_position === 'right' ? 'ml-auto' : '') }}"
                                   style="color: {{ $slider->text_color ?? '#ffffff' }}; opacity: 0.9;">
                                    {{ $slider->description }}
                                </p>
                            @endif

                            @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}"
                                   class="inline-flex items-center gap-3 group
                                   {{ $slider->button_style === 'primary' ? 'bg-white text-black hover:bg-gray-100' : '' }}
                                   {{ $slider->button_style === 'secondary' ? 'bg-black text-white hover:bg-gray-900' : '' }}
                                   {{ $slider->button_style === 'outline' ? 'bg-transparent border-2 border-white text-white hover:bg-white hover:text-black' : '' }}
                                   px-8 py-4 text-sm uppercase tracking-[0.15em] font-medium transition-all duration-300">
                                    {{ $slider->button_text }}
                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($sliders->count() > 1)
        <!-- Navigation Arrows -->
        <button @click="prev()"
                class="absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-center text-white/70 hover:text-white transition-all duration-300 group z-10">
            <span class="absolute inset-0 border border-white/30 group-hover:border-white/60 transition-colors"></span>
            <svg class="w-5 h-5 lg:w-6 lg:h-6 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button @click="next()"
                class="absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-center text-white/70 hover:text-white transition-all duration-300 group z-10">
            <span class="absolute inset-0 border border-white/30 group-hover:border-white/60 transition-colors"></span>
            <svg class="w-5 h-5 lg:w-6 lg:h-6 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Progress Bar / Dots -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10">
            <div class="flex items-center gap-3">
                @foreach($sliders as $index => $slider)
                    <button @click="goTo({{ $index }})"
                            class="group relative h-1 transition-all duration-500 overflow-hidden"
                            :class="currentSlide === {{ $index }} ? 'w-12 bg-white' : 'w-6 bg-white/40 hover:bg-white/60'">
                        <!-- Progress fill for active slide -->
                        <span x-show="currentSlide === {{ $index }}"
                              class="absolute inset-0 bg-white origin-left"
                              :style="currentSlide === {{ $index }} ? 'animation: progressFill 5s linear forwards' : ''">
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Slide Counter -->
        <div class="absolute bottom-8 right-4 lg:right-8 text-white/70 text-sm font-medium tracking-wider z-10">
            <span x-text="String(currentSlide + 1).padStart(2, '0')">01</span>
            <span class="mx-2">/</span>
            <span>{{ str_pad($sliders->count(), 2, '0', STR_PAD_LEFT) }}</span>
        </div>
    @endif

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-4 lg:left-8 z-10 hidden lg:block">
        <div class="flex items-center gap-3 text-white/60">
            <div class="w-px h-12 bg-white/30 relative overflow-hidden">
                <span class="absolute top-0 left-0 w-full bg-white animate-scroll-line" style="animation: scrollLine 2s ease-in-out infinite;"></span>
            </div>
            <span class="text-xs uppercase tracking-[0.2em] -rotate-90 origin-left translate-x-2">Scroll</span>
        </div>
    </div>
</section>

<style>
    @keyframes progressFill {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }

    @keyframes scrollLine {
        0% { height: 0; top: 0; }
        50% { height: 100%; top: 0; }
        51% { height: 100%; top: 0; }
        100% { height: 0; top: 100%; }
    }
</style>

<script>
function heroSlider(totalSlides) {
    return {
        currentSlide: 0,
        totalSlides: totalSlides,
        autoplayInterval: null,
        autoplayDuration: 5000,

        init() {
            this.startAutoplay();

            // Pause on hover
            this.$el.addEventListener('mouseenter', () => this.stopAutoplay());
            this.$el.addEventListener('mouseleave', () => this.startAutoplay());

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') this.prev();
                if (e.key === 'ArrowRight') this.next();
            });
        },

        startAutoplay() {
            this.stopAutoplay();
            this.autoplayInterval = setInterval(() => this.next(), this.autoplayDuration);
        },

        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },

        next() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },

        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },

        goTo(index) {
            this.currentSlide = index;
            this.startAutoplay();
        }
    }
}
</script>
@endif
