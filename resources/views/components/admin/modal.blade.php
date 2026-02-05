@props([
    'name' => 'modal',
    'maxWidth' => 'lg',
    'title' => null,
    'footer' => null,
])

@php
    $maxWidths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        'full' => 'max-w-full mx-4',
    ];
@endphp

<div x-data="{ show: false }"
     x-on:open-modal-{{ $name }}.window="show = true"
     x-on:close-modal-{{ $name }}.window="show = false"
     x-on:keydown.escape.window="show = false"
     x-cloak>

    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50"
         @click="show = false">
    </div>

    <!-- Modal -->
    <div x-show="show"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         @click.self="show = false">

        <div {{ $attributes->merge(['class' => "bg-white rounded-xl shadow-xl w-full {$maxWidths[$maxWidth]} overflow-hidden"]) }}>
            <!-- Header -->
            @if($title)
                <div class="px-6 py-4 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
                        <button @click="show = false"
                                type="button"
                                class="p-1 text-slate-400 hover:text-slate-600 rounded transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Body -->
            <div class="px-6 py-4">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if($footer)
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
