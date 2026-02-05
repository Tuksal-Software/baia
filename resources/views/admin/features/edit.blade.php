@extends('layouts.admin')

@section('title', __('Edit Feature'))

@section('breadcrumb')
    <a href="{{ route('admin.features.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Features') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $feature->title }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit Feature') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $feature->title }}</p>
        </div>
        <form action="{{ route('admin.features.destroy', $feature) }}"
              method="POST"
              onsubmit="return confirm('{{ __('Are you sure you want to delete this feature?') }}')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                {{ __('Delete') }}
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.features.update', $feature) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('Basic Information')">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="icon"
                            label="{{ __('Icon') }}"
                            :options="$icons"
                            :value="$feature->icon"
                            required
                        />

                        <x-admin.form-translatable-input
                            name="title"
                            label="{{ __('Title') }}"
                            :value="$feature->getTranslations('title')"
                            required
                        />

                        <x-admin.form-translatable-textarea
                            name="description"
                            label="{{ __('Description') }}"
                            :value="$feature->getTranslations('description')"
                            :rows="3"
                        />

                        <x-admin.form-input
                            name="link"
                            label="{{ __('Link') }}"
                            :value="$feature->link"
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
                            :checked="$feature->is_active"
                        />

                        <x-admin.form-select
                            name="position"
                            label="{{ __('Position') }}"
                            :options="$positions"
                            :value="$feature->position"
                            required
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="{{ __('Order') }}"
                            :value="$feature->order"
                            min="0"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Information')">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Created') }}</span>
                            <span class="text-slate-900">{{ $feature->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Last Updated') }}</span>
                            <span class="text-slate-900">{{ $feature->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                {{ __('Save Changes') }}
            </x-admin.button>
            <x-admin.button href="{{ route('admin.features.index') }}" variant="ghost">
                {{ __('Cancel') }}
            </x-admin.button>
        </div>
    </form>
@endsection
