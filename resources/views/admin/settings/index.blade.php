@extends('layouts.admin')

@section('title', __('Site Settings'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Settings') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Site Settings') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __("Manage your site's general settings") }}</p>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div class="flex gap-2 mb-6 flex-wrap">
        @foreach($groups as $key => $label)
            <a href="{{ route('admin.settings.index', ['group' => $key]) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                      {{ $activeGroup === $key
                          ? 'bg-primary-600 text-white'
                          : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                @switch($key)
                    @case('site')
                        <i class="fas fa-globe mr-2"></i>
                        @break
                    @case('contact')
                        <i class="fas fa-address-book mr-2"></i>
                        @break
                    @case('social')
                        <i class="fas fa-share-alt mr-2"></i>
                        @break
                    @case('seo')
                        <i class="fas fa-search mr-2"></i>
                        @break
                    @case('payment')
                        <i class="fas fa-credit-card mr-2"></i>
                        @break
                    @case('shipping')
                        <i class="fas fa-truck mr-2"></i>
                        @break
                    @default
                        <i class="fas fa-cog mr-2"></i>
                @endswitch
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="group" value="{{ $activeGroup }}">

        <x-admin.card>
            <div class="space-y-6">
                @foreach($settings as $setting)
                    <div class="pb-6 border-b border-slate-100 last:border-0 last:pb-0">
                        @switch($setting->type)
                            @case('textarea')
                                <x-admin.form-textarea
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :value="old('settings.' . $setting->key, $setting->value)"
                                    :hint="$setting->description"
                                    rows="3"
                                />
                                @break

                            @case('boolean')
                                <x-admin.form-toggle
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :description="$setting->description"
                                    :checked="old('settings.' . $setting->key, $setting->value)"
                                    value="1"
                                />
                                @break

                            @case('image')
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        {{ __($setting->label) }}
                                    </label>
                                    @if($setting->description)
                                        <p class="text-sm text-slate-500 mb-3">{{ $setting->description }}</p>
                                    @endif

                                    <div class="flex items-start gap-4">
                                        @if($setting->value)
                                            <div class="relative" x-data="{ removed: false }" x-show="!removed">
                                                <img src="{{ image_url($setting->value, 'settings') }}"
                                                     class="w-24 h-24 object-cover rounded-lg border border-slate-200"
                                                     alt="{{ __($setting->label) }}">
                                                <button type="button"
                                                        @click="removed = true; $refs.removeInput.checked = true"
                                                        class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                                <input type="checkbox"
                                                       x-ref="removeInput"
                                                       name="remove_images[{{ $setting->key }}]"
                                                       value="1"
                                                       class="hidden">
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <label class="block cursor-pointer">
                                                <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-primary-400 hover:bg-primary-50 transition-colors">
                                                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                                        <i class="fas fa-cloud-upload-alt text-slate-400"></i>
                                                    </div>
                                                    <p class="text-sm font-medium text-slate-700">{{ __('Upload File') }}</p>
                                                    <p class="text-xs text-slate-500 mt-1">PNG, JPG (max. 2MB)</p>
                                                </div>
                                                <input type="file"
                                                       name="settings[{{ $setting->key }}]"
                                                       accept="image/*"
                                                       class="hidden">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @break

                            @case('select')
                                @php
                                    $options = [];
                                    foreach(explode(',', $setting->description ?? '') as $option) {
                                        $trimmed = trim($option);
                                        $options[$trimmed] = ucfirst($trimmed);
                                    }
                                @endphp
                                <x-admin.form-select
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :value="old('settings.' . $setting->key, $setting->value)"
                                    :options="$options"
                                    :placeholder="__('Choose...')"
                                />
                                @break

                            @case('color')
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        {{ __($setting->label) }}
                                    </label>
                                    @if($setting->description)
                                        <p class="text-sm text-slate-500 mb-3">{{ $setting->description }}</p>
                                    @endif

                                    <div class="flex items-center gap-3" x-data="{
                                        color: '{{ old('settings.' . $setting->key, $setting->value) ?: '#000000' }}'
                                    }">
                                        <input type="color"
                                               x-model="color"
                                               class="w-12 h-12 rounded-lg border border-slate-300 cursor-pointer p-1">
                                        <input type="text"
                                               name="settings[{{ $setting->key }}]"
                                               x-model="color"
                                               class="flex-1 max-w-[120px] rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500"
                                               placeholder="#000000">
                                        <div class="w-10 h-10 rounded-lg border border-slate-200" :style="'background-color: ' + color"></div>
                                    </div>
                                </div>
                                @break

                            @case('number')
                                <x-admin.form-input
                                    type="number"
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :value="old('settings.' . $setting->key, $setting->value)"
                                    :hint="$setting->description"
                                />
                                @break

                            @case('email')
                                <x-admin.form-input
                                    type="email"
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :value="old('settings.' . $setting->key, $setting->value)"
                                    :hint="$setting->description"
                                    icon="fa-envelope"
                                />
                                @break

                            @case('url')
                                <x-admin.form-input
                                    type="url"
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :value="old('settings.' . $setting->key, $setting->value)"
                                    :hint="$setting->description"
                                    icon="fa-link"
                                />
                                @break

                            @case('tel')
                                <x-admin.form-input
                                    type="tel"
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :value="old('settings.' . $setting->key, $setting->value)"
                                    :hint="$setting->description"
                                    icon="fa-phone"
                                />
                                @break

                            @default
                                <x-admin.form-input
                                    name="settings[{{ $setting->key }}]"
                                    :label="__($setting->label)"
                                    :value="old('settings.' . $setting->key, $setting->value)"
                                    :hint="$setting->description"
                                />
                        @endswitch
                    </div>
                @endforeach

                @if($settings->isEmpty())
                    <x-admin.empty-state
                        icon="fa-cog"
                        :title="__('Setting not found')"
                        :description="__('No settings defined for this category yet.')"
                    />
                @endif
            </div>

            <x-slot:footerSlot>
                <div class="flex items-center justify-end gap-3">
                    <x-admin.button href="{{ route('admin.settings.index') }}" variant="ghost">
                        {{ __('Cancel') }}
                    </x-admin.button>
                    <x-admin.button type="submit" icon="fa-save">
                        {{ __('Save Changes') }}
                    </x-admin.button>
                </div>
            </x-slot:footerSlot>
        </x-admin.card>
    </form>
@endsection
