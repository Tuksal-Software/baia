@extends('layouts.admin')

@section('title', __('New Feature'))

@section('breadcrumb')
    <a href="{{ route('admin.features.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Features') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New Feature') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New Feature') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Create a new feature') }}</p>
    </div>

    <form action="{{ route('admin.features.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('Basic Information')">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="icon"
                            label="{{ __('Icon') }}"
                            :options="$icons"
                            required
                            hint="{{ __('Using Lucide icons') }}"
                        />

                        <x-admin.form-translatable-input
                            name="title"
                            label="{{ __('Title') }}"
                            placeholder="{{ __('Feature title') }}"
                            required
                        />

                        <x-admin.form-translatable-textarea
                            name="description"
                            label="{{ __('Description') }}"
                            :rows="3"
                        />

                        <x-admin.form-input
                            name="link"
                            label="{{ __('Link') }}"
                            placeholder="/page/..."
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
                            description="{{ __('Feature is visible on the site') }}"
                            :checked="old('is_active', true)"
                        />

                        <x-admin.form-select
                            name="position"
                            label="{{ __('Position') }}"
                            :options="$positions"
                            :value="old('position', 'home')"
                            required
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
            <x-admin.button href="{{ route('admin.features.index') }}" variant="ghost">
                {{ __('Cancel') }}
            </x-admin.button>
        </div>
    </form>
@endsection
