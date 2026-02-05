@extends('layouts.admin')

@section('title', __('Edit Section'))

@section('breadcrumb')
    <a href="{{ route('admin.home-sections.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Home Sections') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $homeSection->title ?: __('Edit Section') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit Section') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $types[$homeSection->type] ?? $homeSection->type }}</p>
        </div>
        <form action="{{ route('admin.home-sections.destroy', $homeSection) }}"
              method="POST"
              onsubmit="return confirm('{{ __('Are you sure you want to delete this section?') }}')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                {{ __('Delete') }}
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('Basic Information')">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="type"
                            label="{{ __('Section Type') }}"
                            :options="$types"
                            :value="$homeSection->type"
                            required
                            id="section-type"
                        />

                        <x-admin.form-translatable-input
                            name="title"
                            label="{{ __('Title') }}"
                            :value="$homeSection->getTranslations('title')"
                            placeholder="{{ __('Section title') }}"
                        />

                        <x-admin.form-translatable-input
                            name="subtitle"
                            label="{{ __('Subtitle') }}"
                            :value="$homeSection->getTranslations('subtitle')"
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
                                :value="$homeSection->settings['type'] ?? ''"
                            />

                            <x-admin.form-input
                                name="settings[limit]"
                                type="number"
                                label="{{ __('Limit') }}"
                                :value="$homeSection->settings['limit'] ?? 12"
                                min="1"
                                max="24"
                            />

                            <x-admin.form-select
                                name="settings[category_id]"
                                label="{{ __('Category (optional)') }}"
                                :options="$categories->pluck('name', 'id')->toArray()"
                                :value="$homeSection->settings['category_id'] ?? ''"
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
                                :value="$homeSection->settings['limit'] ?? 6"
                                min="1"
                                max="12"
                            />

                            <x-admin.form-checkbox
                                name="settings[show_all_link]"
                                label="{{ __('Show View All link') }}"
                                :checked="$homeSection->settings['show_all_link'] ?? false"
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
                                :value="$homeSection->settings['position'] ?? ''"
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
                                :value="$homeSection->settings['position'] ?? ''"
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
                                :value="$homeSection->settings['background_color'] ?? '#f5f5dc'"
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
                            :checked="$homeSection->is_active"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="{{ __('Order') }}"
                            :value="$homeSection->order"
                            min="0"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Information')">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Created') }}</span>
                            <span class="text-slate-900">{{ $homeSection->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Last Updated') }}</span>
                            <span class="text-slate-900">{{ $homeSection->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                {{ __('Save Changes') }}
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
