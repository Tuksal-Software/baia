@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'iconRight' => null,
    'loading' => false,
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500',
        'secondary' => 'bg-slate-100 text-slate-700 hover:bg-slate-200 focus:ring-slate-500',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-500',
        'warning' => 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100 focus:ring-slate-500',
        'outline' => 'border border-slate-300 text-slate-700 hover:bg-slate-50 focus:ring-slate-500',
        'outline-primary' => 'border border-primary-300 text-primary-700 hover:bg-primary-50 focus:ring-primary-500',
        'outline-danger' => 'border border-rose-300 text-rose-700 hover:bg-rose-50 focus:ring-rose-500',
    ];

    $sizes = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        'xl' => 'px-6 py-3 text-base',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="fas {{ $icon }} {{ $size === 'xs' ? 'text-xs' : 'text-sm' }}"></i>
        @endif
        {{ $slot }}
        @if($iconRight)
            <i class="fas {{ $iconRight }} {{ $size === 'xs' ? 'text-xs' : 'text-sm' }}"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $classes]) }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $loading ? 'disabled' : '' }}>
        @if($loading)
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            <i class="fas {{ $icon }} {{ $size === 'xs' ? 'text-xs' : 'text-sm' }}"></i>
        @endif
        {{ $slot }}
        @if($iconRight && !$loading)
            <i class="fas {{ $iconRight }} {{ $size === 'xs' ? 'text-xs' : 'text-sm' }}"></i>
        @endif
    </button>
@endif
