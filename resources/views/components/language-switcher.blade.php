@php
    $locales = config('app.available_locales', []);
    $currentLocale = app()->getLocale();
    $currentLocaleData = $locales[$currentLocale] ?? ['name' => 'TR', 'flag' => '🇹🇷'];
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open"
            class="flex items-center gap-1.5 p-2 text-gray-700 hover:text-black transition-colors"
            title="{{ __('Language') }}">
        <span class="text-sm">{{ $currentLocaleData['flag'] ?? '' }}</span>
        <span class="hidden sm:inline text-xs font-medium uppercase">{{ $currentLocale }}</span>
        <svg class="w-3 h-3 text-gray-400" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Dropdown -->
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="absolute right-0 top-full mt-2 w-40 bg-white border border-gray-100 shadow-lg py-1 z-50">
        @foreach($locales as $locale => $data)
            <a href="{{ route('language.switch', $locale) }}"
               class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors {{ $locale === $currentLocale ? 'bg-gray-50 text-black font-medium' : 'text-gray-700' }}">
                <span>{{ $data['flag'] ?? '' }}</span>
                <span>{{ $data['native'] ?? $data['name'] }}</span>
                @if($locale === $currentLocale)
                    <svg class="w-4 h-4 ml-auto text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                @endif
            </a>
        @endforeach
    </div>
</div>
