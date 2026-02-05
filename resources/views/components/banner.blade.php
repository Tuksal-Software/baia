@props(['banner'])

@if($banner)
<section class="py-8">
    <div class="container mx-auto px-4">
        <a href="{{ $banner->link ?? '#' }}" class="block relative group overflow-hidden">
            <picture>
                @if($banner->image_mobile)
                    <source media="(max-width: 768px)" srcset="{{ $banner->mobile_image_url }}">
                @endif
                <img src="{{ $banner->image_url }}"
                     alt="{{ $banner->title ?? $banner->name }}"
                     class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-105">
            </picture>

            <!-- Overlay Content -->
            @if($banner->title || $banner->subtitle)
                <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition-colors">
                    <div class="text-center text-white px-4">
                        @if($banner->subtitle)
                            <p class="text-sm uppercase tracking-widest mb-2 opacity-90">{{ $banner->subtitle }}</p>
                        @endif
                        @if($banner->title)
                            <h3 class="text-2xl md:text-4xl font-serif font-bold">{{ $banner->title }}</h3>
                        @endif
                    </div>
                </div>
            @endif
        </a>
    </div>
</section>
@endif
