@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'Secin...',
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'multiple' => false,
])

@php
    $hasError = $errors->has($name);
    $inputId = $attributes->get('id', $name);
    $selectedValue = old($name, $value);
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
        <select name="{{ $name }}{{ $multiple ? '[]' : '' }}"
                id="{{ $inputId }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $multiple ? 'multiple' : '' }}
                {{ $attributes->except(['class', 'id'])->merge([
                    'class' => 'block w-full rounded-lg border text-sm transition-colors appearance-none
                               focus:outline-none focus:ring-2 focus:ring-offset-0
                               disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed
                               ' . ($hasError
                                   ? 'border-rose-300 text-rose-900 focus:border-rose-500 focus:ring-rose-200'
                                   : 'border-slate-300 text-slate-900 focus:border-primary-500 focus:ring-primary-200')
                               . ' px-3 py-2.5 pr-10'
                ]) }}>

            @if($placeholder && !$multiple)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach($options as $optionValue => $optionLabel)
                @if(is_array($optionLabel))
                    {{-- Option group --}}
                    <optgroup label="{{ $optionValue }}">
                        @foreach($optionLabel as $subValue => $subLabel)
                            <option value="{{ $subValue }}"
                                    {{ $multiple
                                        ? (is_array($selectedValue) && in_array($subValue, $selectedValue) ? 'selected' : '')
                                        : ($selectedValue == $subValue ? 'selected' : '') }}>
                                {{ $subLabel }}
                            </option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $optionValue }}"
                            {{ $multiple
                                ? (is_array($selectedValue) && in_array($optionValue, $selectedValue) ? 'selected' : '')
                                : ($selectedValue == $optionValue ? 'selected' : '') }}>
                        {{ $optionLabel }}
                    </option>
                @endif
            @endforeach
        </select>

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
        </div>
    </div>

    @if($hint && !$hasError)
        <p class="mt-1.5 text-sm text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>
