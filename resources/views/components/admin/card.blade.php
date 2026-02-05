@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200']) }}>
    @if($title || isset($header))
        <div class="px-6 py-4 border-b border-slate-200">
            @if(isset($header))
                {{ $header }}
            @else
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
                        @if($subtitle)
                            <p class="text-sm text-slate-500 mt-0.5">{{ $subtitle }}</p>
                        @endif
                    </div>
                    @if(isset($actions))
                        <div class="flex items-center gap-2">
                            {{ $actions }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>

    @if($footer || isset($footerSlot))
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl">
            {{ $footer ?? $footerSlot }}
        </div>
    @endif
</div>
