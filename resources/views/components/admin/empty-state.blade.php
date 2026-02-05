@props([
    'icon' => 'fa-inbox',
    'title' => 'Veri bulunamadi',
    'description' => null,
    'action' => null,
    'actionUrl' => null,
    'actionIcon' => 'fa-plus',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 px-4']) }}>
    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
        <i class="fas {{ $icon }} text-2xl text-slate-400"></i>
    </div>

    <h3 class="text-lg font-medium text-slate-900 mb-1">{{ $title }}</h3>

    @if($description)
        <p class="text-sm text-slate-500 text-center max-w-sm mb-4">{{ $description }}</p>
    @endif

    @if($action && $actionUrl)
        <x-admin.button :href="$actionUrl" :icon="$actionIcon" variant="primary">
            {{ $action }}
        </x-admin.button>
    @endif

    {{ $slot }}
</div>
