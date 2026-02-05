@extends('layouts.admin')

@section('title', __('New Slider'))

@section('breadcrumb')
    <a href="{{ route('admin.sliders.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Sliders') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New Slider') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New Slider') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Create a new slider') }}</p>
    </div>

    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('Basic Information')">
                    <div class="space-y-4">
                        <x-admin.form-translatable-input
                            name="title"
                            label="{{ __('Title') }}"
                            placeholder="{{ __('Slider title') }}"
                        />

                        <x-admin.form-translatable-input
                            name="subtitle"
                            label="{{ __('Subtitle') }}"
                            placeholder="{{ __('Slider subtitle') }}"
                        />

                        <x-admin.form-translatable-textarea
                            name="description"
                            label="{{ __('Description') }}"
                            :rows="3"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Images')">
                    <div class="space-y-4">
                        <x-admin.form-image
                            name="image"
                            label="{{ __('Image (Desktop)') }}"
                            required
                            hint="{{ __('Recommended size: 1920x800px') }}"
                        />

                        <x-admin.form-image
                            name="image_mobile"
                            label="{{ __('Image (Mobile)') }}"
                            hint="{{ __('Recommended size: 768x600px') }}"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Button Settings')">
                    <div class="space-y-4">
                        <x-admin.form-translatable-input
                            name="button_text"
                            label="{{ __('Button Text') }}"
                            placeholder="{{ __('e.g. Discover') }}"
                        />

                        <x-admin.form-input
                            name="button_link"
                            label="{{ __('Button Link') }}"
                            placeholder="/category/..."
                        />

                        <x-admin.form-select
                            name="button_style"
                            label="{{ __('Button Style') }}"
                            :options="[
                                'primary' => 'Primary',
                                'secondary' => 'Secondary',
                                'outline' => 'Outline',
                            ]"
                            :value="old('button_style', 'primary')"
                        />
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card :title="__('Publish Settings')">
                    <div class="space-y-4">
                        <x-admin.form-toggle
                            name="is_active"
                            label="{{ __('Active') }}"
                            description="{{ __('Slider is visible on the site') }}"
                            :checked="old('is_active', true)"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="{{ __('Order') }}"
                            :value="old('order', 0)"
                            min="0"
                        />

                        <x-admin.form-input
                            name="starts_at"
                            type="datetime-local"
                            label="{{ __('Start Date') }}"
                        />

                        <x-admin.form-input
                            name="ends_at"
                            type="datetime-local"
                            label="{{ __('End Date') }}"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Display Settings')">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="text_position"
                            label="{{ __('Text Position') }}"
                            :options="[
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ]"
                            :value="old('text_position', 'center')"
                        />

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('Text Color') }}</label>
                            <input type="color"
                                   name="text_color"
                                   value="{{ old('text_color', '#ffffff') }}"
                                   class="w-full h-10 rounded-lg border border-slate-300 cursor-pointer">
                        </div>

                        <x-admin.form-input
                            name="overlay_color"
                            label="{{ __('Overlay Color') }}"
                            placeholder="rgba(0,0,0,0.3)"
                        />
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                {{ __('Save') }}
            </x-admin.button>
            <x-admin.button href="{{ route('admin.sliders.index') }}" variant="ghost">
                {{ __('Cancel') }}
            </x-admin.button>
        </div>
    </form>
@endsection
