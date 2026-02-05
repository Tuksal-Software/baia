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
    <button type="button"
            role="switch"
            x-data="{ checked: {{ $isChecked ? 'true' : 'false' }} }"
            :aria-checked="checked"
            @click="checked = !checked; $refs.input.value = checked ? '{{ $value }}' : ''"
            :class="checked ? 'bg-primary-600' : 'bg-slate-200'"
            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
            {{ $disabled ? 'disabled' : '' }}>
        <span :class="checked ? 'translate-x-5' : 'translate-x-0'"
              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
    </button>

    <input type="hidden"
           name="{{ $name }}"
           x-ref="input"
           value="{{ $isChecked ? $value : '' }}">

    @if($label || $description)
        <div class="flex-1">
            @if($label)
                <label for="{{ $inputId }}" class="text-sm font-medium text-slate-700 cursor-pointer" @click="checked = !checked">
                    {{ $label }}
                </label>
            @endif
            @if($description)
                <p class="text-sm text-slate-500">{{ $description }}</p>
            @endif
        </div>
    @endif
</div>
