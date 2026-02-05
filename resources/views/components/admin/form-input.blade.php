@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'icon' => null,
    'iconRight' => null,
    'prefix' => null,
    'suffix' => null,
])

@php
    $hasError = $errors->has($name);
    $inputId = $attributes->get('id', $name);
    $inputValue = old($name, $value);
@endphp

<div {{ $attributes->only('class')->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas {{ $icon }} text-slate-400"></i>
            </div>
        @endif

        @if($prefix)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-slate-500 text-sm">{{ $prefix }}</span>
            </div>
        @endif

        <input type="{{ $type }}"
               name="{{ $name }}"
               id="{{ $inputId }}"
               value="{{ $inputValue }}"
               placeholder="{{ $placeholder }}"
               {{ $required ? 'required' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               {{ $readonly ? 'readonly' : '' }}
               {{ $attributes->except(['class', 'id'])->merge([
                   'class' => 'block w-full rounded-lg border text-sm transition-colors
                              focus:outline-none focus:ring-2 focus:ring-offset-0
                              disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed
                              ' . ($hasError
                                  ? 'border-rose-300 text-rose-900 placeholder-rose-300 focus:border-rose-500 focus:ring-rose-200'
                                  : 'border-slate-300 text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:ring-primary-200')
                              . ($icon || $prefix ? ' pl-10' : ' px-3')
                              . ($iconRight || $suffix ? ' pr-10' : ' px-3')
                              . ' py-2.5'
               ]) }}>

        @if($iconRight)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="fas {{ $iconRight }} text-slate-400"></i>
            </div>
        @endif

        @if($suffix)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-slate-500 text-sm">{{ $suffix }}</span>
            </div>
        @endif
    </div>

    @if($hint && !$hasError)
        <p class="mt-1.5 text-sm text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>
