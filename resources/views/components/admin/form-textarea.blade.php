@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'rows' => 4,
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

    <textarea name="{{ $name }}"
              id="{{ $inputId }}"
              rows="{{ $rows }}"
              placeholder="{{ $placeholder }}"
              {{ $required ? 'required' : '' }}
              {{ $disabled ? 'disabled' : '' }}
              {{ $readonly ? 'readonly' : '' }}
              {{ $attributes->except(['class', 'id'])->merge([
                  'class' => 'block w-full rounded-lg border text-sm transition-colors resize-y
                             focus:outline-none focus:ring-2 focus:ring-offset-0
                             disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed
                             ' . ($hasError
                                 ? 'border-rose-300 text-rose-900 placeholder-rose-300 focus:border-rose-500 focus:ring-rose-200'
                                 : 'border-slate-300 text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:ring-primary-200')
                             . ' px-3 py-2.5'
              ]) }}>{{ $inputValue }}</textarea>

    @if($hint && !$hasError)
        <p class="mt-1.5 text-sm text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>
