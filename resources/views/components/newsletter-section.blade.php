@props(['title' => 'Bultenimize Katilın', 'subtitle' => 'Yeni urunler ve kampanyalardan haberdar olun', 'backgroundColor' => '#f5f5dc'])

<section class="py-20" style="background-color: {{ $backgroundColor }}">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            @if($subtitle)
                <p class="text-sm uppercase tracking-widest text-gray-600 mb-3">{{ $subtitle }}</p>
            @endif
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-black mb-8">{{ $title }}</h2>

            @if(session('newsletter_success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded mb-6">
                    {{ session('newsletter_success') }}
                </div>
            @else
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                    @csrf
                    <input type="email"
                           name="email"
                           placeholder="E-posta adresiniz"
                           required
                           class="flex-1 px-6 py-4 border border-gray-300 focus:border-black focus:ring-0 outline-none transition-colors">
                    <button type="submit"
                            class="px-8 py-4 bg-black text-white uppercase text-sm tracking-wider hover:bg-gray-800 transition-colors">
                        Abone Ol
                    </button>
                </form>
                @error('email')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-4">
                    Abone olarak gizlilik politikamizi kabul etmis olursunuz.
                </p>
            @endif
        </div>
    </div>
</section>
