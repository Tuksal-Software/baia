@props([
    'name',
    'label' => null,
    'value' => null,
    'hint' => null,
    'required' => false,
    'accept' => 'image/*',
    'multiple' => false,
    'preview' => true,
])

@php
    $hasError = $errors->has($name);
    $inputId = $attributes->get('id', $name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => '']) }}
     x-data="{
        files: [],
        existingImage: '{{ $value }}',
        previewUrls: [],
        handleFiles(event) {
            this.files = Array.from(event.target.files);
            this.previewUrls = [];
            this.files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => this.previewUrls.push(e.target.result);
                reader.readAsDataURL(file);
            });
        },
        removeFile(index) {
            this.files.splice(index, 1);
            this.previewUrls.splice(index, 1);
            if (this.files.length === 0) {
                this.$refs.input.value = '';
            }
        },
        removeExisting() {
            this.existingImage = '';
        }
     }">

    @if($label)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <!-- Existing Image Preview -->
    <template x-if="existingImage && previewUrls.length === 0">
        <div class="mb-3">
            <div class="relative inline-block">
                <img :src="existingImage.startsWith('http') ? existingImage : '/storage/' + existingImage"
                     class="w-32 h-32 object-cover rounded-lg border border-slate-200"
                     alt="Current image">
                <button type="button"
                        @click="removeExisting()"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>
    </template>

    <!-- New Image Previews -->
    <template x-if="previewUrls.length > 0">
        <div class="mb-3 flex flex-wrap gap-3">
            <template x-for="(url, index) in previewUrls" :key="index">
                <div class="relative">
                    <img :src="url"
                         class="w-32 h-32 object-cover rounded-lg border border-slate-200"
                         alt="Preview">
                    <button type="button"
                            @click="removeFile(index)"
                            class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </template>
        </div>
    </template>

    <!-- Upload Area -->
    <div class="relative">
        <input type="file"
               name="{{ $name }}{{ $multiple ? '[]' : '' }}"
               id="{{ $inputId }}"
               x-ref="input"
               accept="{{ $accept }}"
               {{ $multiple ? 'multiple' : '' }}
               {{ $required && !$value ? 'required' : '' }}
               @change="handleFiles($event)"
               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

        <div class="border-2 border-dashed rounded-lg p-6 text-center transition-colors
                    {{ $hasError ? 'border-rose-300 bg-rose-50' : 'border-slate-300 hover:border-primary-400 hover:bg-primary-50' }}">
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-cloud-upload-alt text-xl text-slate-400"></i>
                </div>
                <p class="text-sm font-medium text-slate-700">
                    Dosya yuklemek icin tiklayin
                </p>
                <p class="text-xs text-slate-500 mt-1">
                    veya surukleyip birakin
                </p>
                <p class="text-xs text-slate-400 mt-2">
                    PNG, JPG, GIF (max. 2MB)
                </p>
            </div>
        </div>
    </div>

    @if($hint && !$hasError)
        <p class="mt-1.5 text-sm text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>
