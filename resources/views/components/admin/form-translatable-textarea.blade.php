@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'rows' => 4,
    'autoTranslate' => true,
])

@php
    $locales = config('app.available_locales', []);
    $defaultLocale = config('app.locale', 'tr');
    $inputId = $attributes->get('id', $name);

    // Parse value - could be array, JSON string, or plain string
    $translations = [];
    if (is_array($value)) {
        $translations = $value;
    } elseif (is_string($value) && json_decode($value) !== null) {
        $translations = json_decode($value, true);
    } elseif (!empty($value)) {
        $translations = [$defaultLocale => $value];
    }

    // Get old values if available
    foreach (array_keys($locales) as $locale) {
        $oldKey = "{$name}.{$locale}";
        if (old($oldKey) !== null) {
            $translations[$locale] = old($oldKey);
        }
    }
@endphp

<div x-data="{
    activeTab: '{{ $defaultLocale }}',
    translations: @js($translations),
    translating: false,
    async autoTranslate() {
        const sourceText = this.translations['{{ $defaultLocale }}'];
        if (!sourceText || sourceText.trim() === '') {
            return;
        }

        this.translating = true;
        try {
            const response = await fetch('{{ route('admin.translations.translate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    text: sourceText,
                    from: '{{ $defaultLocale }}',
                    to: ['en', 'de']
                })
            });

            const data = await response.json();
            if (data.success) {
                Object.keys(data.translations).forEach(locale => {
                    if (locale !== '{{ $defaultLocale }}') {
                        this.translations[locale] = data.translations[locale];
                    }
                });
            }
        } catch (error) {
            console.error('Translation failed:', error);
        }
        this.translating = false;
    }
}" {{ $attributes->only('class')->merge(['class' => '']) }}>
    @if($label)
        <div class="flex items-center justify-between mb-1.5">
            <label class="block text-sm font-medium text-slate-700">
                {{ $label }}
                @if($required)
                    <span class="text-rose-500">*</span>
                @endif
            </label>
            @if($autoTranslate)
                <button type="button"
                        @click="autoTranslate()"
                        :disabled="translating"
                        class="inline-flex items-center gap-1.5 text-xs text-primary-600 hover:text-primary-700 disabled:opacity-50 disabled:cursor-wait">
                    <i class="fas fa-language" :class="translating && 'animate-pulse'"></i>
                    <span x-text="translating ? '{{ __('Translating...') }}' : '{{ __('Auto Translate') }}'"></span>
                </button>
            @endif
        </div>
    @endif

    <!-- Language Tabs -->
    <div class="border border-slate-300 rounded-lg overflow-hidden">
        <div class="flex bg-slate-50 border-b border-slate-300">
            @foreach($locales as $locale => $localeData)
                <button type="button"
                        @click="activeTab = '{{ $locale }}'"
                        :class="activeTab === '{{ $locale }}'
                            ? 'bg-white text-primary-600 border-b-2 border-primary-600 -mb-px'
                            : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100'"
                        class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium transition-colors">
                    <span>{{ $localeData['flag'] ?? '' }}</span>
                    <span>{{ strtoupper($locale) }}</span>
                </button>
            @endforeach
        </div>

        <div class="p-3">
            @foreach($locales as $locale => $localeData)
                <div x-show="activeTab === '{{ $locale }}'" x-cloak>
                    <textarea name="{{ $name }}[{{ $locale }}]"
                              id="{{ $inputId }}_{{ $locale }}"
                              x-model="translations['{{ $locale }}']"
                              rows="{{ $rows }}"
                              placeholder="{{ $placeholder }}"
                              {{ $required && $locale === $defaultLocale ? 'required' : '' }}
                              {{ $disabled ? 'disabled' : '' }}
                              {{ $readonly ? 'readonly' : '' }}
                              class="block w-full rounded-lg border text-sm transition-colors resize-y
                                     focus:outline-none focus:ring-2 focus:ring-offset-0
                                     disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed
                                     border-slate-300 text-slate-900 placeholder-slate-400
                                     focus:border-primary-500 focus:ring-primary-200 px-3 py-2.5
                                     @error("{$name}.{$locale}") border-rose-300 @enderror"></textarea>
                    @error("{$name}.{$locale}")
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>
    </div>

    @if($hint)
        <p class="mt-1.5 text-sm text-slate-500">{{ $hint }}</p>
    @endif
</div>
