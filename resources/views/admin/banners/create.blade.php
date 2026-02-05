@extends('layouts.admin')

@section('title', __('New Banner'))

@section('breadcrumb')
    <a href="{{ route('admin.banners.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Banners') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New Banner') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New Banner') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Create a new banner') }}</p>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('Basic Information')">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            label="{{ __('Banner Name') }}"
                            placeholder="{{ __('Banner name') }}"
                            required
                        />

                        <x-admin.form-select
                            name="position"
                            label="{{ __('Position') }}"
                            :options="$positions"
                            required
                        />

                        <x-admin.form-translatable-input
                            name="title"
                            label="{{ __('Title') }}"
                            placeholder="{{ __('Banner title (optional)') }}"
                        />

                        <x-admin.form-translatable-input
                            name="subtitle"
                            label="{{ __('Subtitle') }}"
                            placeholder="{{ __('Banner subtitle (optional)') }}"
                        />

                        <x-admin.form-input
                            name="link"
                            label="{{ __('Link') }}"
                            placeholder="/category/..."
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Images')">
                    <div class="space-y-4">
                        <x-admin.form-image
                            name="image"
                            label="{{ __('Image (Desktop)') }}"
                            required
                        />

                        <x-admin.form-image
                            name="image_mobile"
                            label="{{ __('Image (Mobile)') }}"
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
                            description="{{ __('Banner is visible on the site') }}"
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
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                {{ __('Save') }}
            </x-admin.button>
            <x-admin.button href="{{ route('admin.banners.index') }}" variant="ghost">
                {{ __('Cancel') }}
            </x-admin.button>
        </div>
    </form>
@endsection
