@props([
    'title',
    'value',
    'icon' => null,
    'trend' => null,
    'trendUp' => true,
    'href' => null,
    'color' => 'primary',
])

@php
    $colors = [
        'primary' => 'bg-primary-100 text-primary-600',
        'success' => 'bg-emerald-100 text-emerald-600',
        'warning' => 'bg-amber-100 text-amber-600',
        'danger' => 'bg-rose-100 text-rose-600',
        'info' => 'bg-sky-100 text-sky-600',
    ];

    $iconBg = $colors[$color] ?? $colors['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200 p-6 hover:border-slate-300 transition-colors']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-slate-500">{{ $title }}</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $value }}</p>

            @if($trend)
                <div class="mt-2 flex items-center gap-1 text-sm">
                    <span class="{{ $trendUp ? 'text-emerald-600' : 'text-rose-600' }}">
                        <i class="fas {{ $trendUp ? 'fa-arrow-up' : 'fa-arrow-down' }} text-xs"></i>
                        {{ $trend }}
                    </span>
                    <span class="text-slate-500">gecen aya gore</span>
                </div>
            @endif
        </div>

        @if($icon)
            <div class="w-12 h-12 rounded-lg {{ $iconBg }} flex items-center justify-center">
                <i class="fas {{ $icon }} text-xl"></i>
            </div>
        @endif
    </div>

    @if($href)
        <a href="{{ $href }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700">
            Detaylari gor
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    @endif

    {{ $slot }}
</div>
