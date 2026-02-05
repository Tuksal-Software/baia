@props([
    'variant' => 'default',
    'size' => 'md',
    'dot' => false,
    'removable' => false,
])

@php
    $baseClasses = 'inline-flex items-center gap-1.5 font-medium rounded-full';

    $variants = [
        'default' => 'bg-slate-100 text-slate-700',
        'primary' => 'bg-primary-100 text-primary-700',
        'success' => 'bg-emerald-100 text-emerald-700',
        'warning' => 'bg-amber-100 text-amber-700',
        'danger' => 'bg-rose-100 text-rose-700',
        'info' => 'bg-sky-100 text-sky-700',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1 text-sm',
    ];

    $dotColors = [
        'default' => 'bg-slate-400',
        'primary' => 'bg-primary-500',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-sky-500',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors[$variant] ?? $dotColors['default'] }}"></span>
    @endif
    {{ $slot }}
    @if($removable)
        <button type="button" class="ml-0.5 hover:opacity-70 focus:outline-none">
            <i class="fas fa-times text-xs"></i>
        </button>
    @endif
</span>
