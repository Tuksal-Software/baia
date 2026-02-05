@props(['categories', 'title' => null, 'subtitle' => null, 'showAllLink' => true])

@if($categories && $categories->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        @if($title)
            <div class="text-center mb-12">
                @if($subtitle)
                    <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">{{ $subtitle }}</p>
                @endif
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-black">{{ $title }}</h2>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                   class="group relative aspect-[4/5] overflow-hidden">
                    <!-- Background Image -->
                    @if($category->image)
                        <img src="{{ $category->image_url }}"
                             alt="{{ $category->name }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gray-200"></div>
                    @endif

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all duration-300"></div>

                    <!-- Content -->
                    <div class="absolute inset-0 flex flex-col justify-end p-6">
                        <h3 class="text-xl md:text-2xl font-serif font-bold text-white mb-2">{{ $category->name }}</h3>
                        <span class="text-white/80 text-sm uppercase tracking-wider group-hover:text-white transition-colors">
                            Koleksiyonu Gor
                            <svg class="inline-block w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        @if($showAllLink)
            <div class="text-center mt-10">
                <a href="{{ route('categories.index') }}"
                   class="inline-block px-8 py-3 border-2 border-black text-black uppercase text-sm tracking-wider hover:bg-black hover:text-white transition-all duration-300">
                    Tum Kategoriler
                </a>
            </div>
        @endif
    </div>
</section>
@endif
