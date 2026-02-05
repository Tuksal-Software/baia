@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'icon' => null,
])

@php
    $types = [
        'info' => [
            'bg' => 'bg-sky-50 border-sky-200',
            'text' => 'text-sky-800',
            'icon' => 'fa-info-circle text-sky-500',
        ],
        'success' => [
            'bg' => 'bg-emerald-50 border-emerald-200',
            'text' => 'text-emerald-800',
            'icon' => 'fa-check-circle text-emerald-500',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 border-amber-200',
            'text' => 'text-amber-800',
            'icon' => 'fa-exclamation-triangle text-amber-500',
        ],
        'danger' => [
            'bg' => 'bg-rose-50 border-rose-200',
            'text' => 'text-rose-800',
            'icon' => 'fa-exclamation-circle text-rose-500',
        ],
    ];

    $config = $types[$type] ?? $types['info'];
    $iconClass = $icon ?? $config['icon'];
@endphp

<div x-data="{ show: true }"
     x-show="show"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     {{ $attributes->merge(['class' => "rounded-lg border p-4 {$config['bg']}"]) }}>
    <div class="flex gap-3">
        <div class="flex-shrink-0">
            <i class="fas {{ $iconClass }}"></i>
        </div>
        <div class="flex-1 {{ $config['text'] }}">
            @if($title)
                <h3 class="text-sm font-semibold mb-1">{{ $title }}</h3>
            @endif
            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <button @click="show = false"
                    type="button"
                    class="flex-shrink-0 {{ $config['text'] }} opacity-50 hover:opacity-100 transition-opacity">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>
