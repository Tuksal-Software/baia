@extends('layouts.admin')

@section('title', __('New Section'))

@section('breadcrumb')
    <a href="{{ route('admin.home-sections.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Home Sections') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New Section') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New Home Section') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Create a new home page section') }}</p>
    </div>

    <form action="{{ route('admin.home-sections.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('Basic Information')">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="type"
                            label="{{ __('Section Type') }}"
                            :options="$types"
                            required
                            id="section-type"
                        />

                        <x-admin.form-translatable-input
                            name="title"
                            label="{{ __('Title') }}"
                            placeholder="{{ __('Section title') }}"
                        />

                        <x-admin.form-translatable-input
                            name="subtitle"
                            label="{{ __('Subtitle') }}"
                            placeholder="{{ __('Section subtitle') }}"
                        />
                    </div>
                </x-admin.card>

                <!-- Dynamic Settings -->
                <div id="settings-products" class="settings-group hidden">
                    <x-admin.card :title="__('Product Settings')">
                        <div class="space-y-4">
                            <x-admin.form-select
                                name="settings[type]"
                                label="{{ __('Product Type') }}"
                                :options="[
                                    'new' => __('New Products'),
                                    'bestseller' => __('Bestsellers'),
                                    'sale' => __('On Sale'),
                                    'featured' => __('Featured Products'),
                                    'category' => __('By Category'),
                                ]"
                            />

                            <x-admin.form-input
                                name="settings[limit]"
                                type="number"
                                label="{{ __('Limit') }}"
                                :value="old('settings.limit', 12)"
                                min="1"
                                max="24"
                            />

                            <x-admin.form-select
                                name="settings[category_id]"
                                label="{{ __('Category (optional)') }}"
                                :options="$categories->pluck('name', 'id')->toArray()"
                                placeholder="- {{ __('Select') }} -"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-categories" class="settings-group hidden">
                    <x-admin.card :title="__('Category Settings')">
                        <div class="space-y-4">
                            <x-admin.form-input
                                name="settings[limit]"
                                type="number"
                                label="{{ __('Limit') }}"
                                :value="old('settings.limit', 6)"
                                min="1"
                                max="12"
                            />

                            <x-admin.form-checkbox
                                name="settings[show_all_link]"
                                label="{{ __('Show View All link') }}"
                                :checked="old('settings.show_all_link', true)"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-banner" class="settings-group hidden">
                    <x-admin.card :title="__('Banner Settings')">
                        <div class="space-y-4">
                            <x-admin.form-select
                                name="settings[position]"
                                label="{{ __('Banner Position') }}"
                                :options="[
                                    'home_top' => __('Home Top'),
                                    'home_middle' => __('Home Middle'),
                                    'home_bottom' => __('Home Bottom'),
                                ]"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-features" class="settings-group hidden">
                    <x-admin.card :title="__('Feature Settings')">
                        <div class="space-y-4">
                            <x-admin.form-select
                                name="settings[position]"
                                label="{{ __('Position') }}"
                                :options="[
                                    'home' => __('Home'),
                                    'footer' => 'Footer',
                                ]"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-newsletter" class="settings-group hidden">
                    <x-admin.card :title="__('Newsletter Settings')">
                        <div class="space-y-4">
                            <x-admin.form-input
                                name="settings[background_color]"
                                label="{{ __('Background Color') }}"
                                :value="old('settings.background_color', '#f5f5dc')"
                                placeholder="#f5f5dc"
                            />
                        </div>
                    </x-admin.card>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card :title="__('Publish Settings')">
                    <div class="space-y-4">
                        <x-admin.form-toggle
                            name="is_active"
                            label="{{ __('Active') }}"
                            description="{{ __('Section is visible on home page') }}"
                            :checked="old('is_active', true)"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="{{ __('Order') }}"
                            :value="old('order', 0)"
                            min="0"
                        />
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                {{ __('Save') }}
            </x-admin.button>
            <x-admin.button href="{{ route('admin.home-sections.index') }}" variant="ghost">
                {{ __('Cancel') }}
            </x-admin.button>
        </div>
    </form>

    <script>
    document.getElementById('section-type').addEventListener('change', function() {
        document.querySelectorAll('.settings-group').forEach(el => el.classList.add('hidden'));
        const selected = document.getElementById('settings-' + this.value);
        if (selected) selected.classList.remove('hidden');
    });
    document.getElementById('section-type').dispatchEvent(new Event('change'));
    </script>
@endsection
