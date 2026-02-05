@props([
    'name',
    'label' => null,
    'description' => null,
    'checked' => false,
    'disabled' => false,
    'value' => '1',
])

@php
    $inputId = $attributes->get('id', $name);
    $isChecked = old($name, $checked);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'flex items-start gap-3']) }}>
    <div class="flex items-center h-5">
        <input type="checkbox"
               name="{{ $name }}"
               id="{{ $inputId }}"
               value="{{ $value }}"
               {{ $isChecked ? 'checked' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 disabled:opacity-50 disabled:cursor-not-allowed">
    </div>

    @if($label || $description)
        <div class="flex-1">
            @if($label)
                <label for="{{ $inputId }}" class="text-sm font-medium text-slate-700 cursor-pointer">
                    {{ $label }}
                </label>
            @endif
            @if($description)
                <p class="text-sm text-slate-500">{{ $description }}</p>
            @endif
        </div>
    @endif
</div>
