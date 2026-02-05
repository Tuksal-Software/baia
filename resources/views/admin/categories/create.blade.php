@extends('layouts.admin')

@section('title', __('New Category'))

@section('breadcrumb')
    <a href="{{ route('admin.categories.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Categories') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New Category') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New Category') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Create a new category') }}</p>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="max-w-2xl">
            <x-admin.card :title="__('Category Information')">
                <div class="space-y-4">
                    <x-admin.form-translatable-input
                        name="name"
                        :label="__('Category Name')"
                        :placeholder="__('Enter category name')"
                        required
                    />

                    <x-admin.form-input
                        name="slug"
                        :label="__('Slug')"
                        :placeholder="__('Auto-generated')"
                        :hint="__('Leave empty to auto-generate from category name')"
                    />

                    <x-admin.form-select
                        name="parent_id"
                        :label="__('Parent Category')"
                        :options="$parentCategories->pluck('name', 'id')->toArray()"
                        :placeholder="__('- Main Category -')"
                        :hint="__('Leave empty to create as main category')"
                    />

                    <x-admin.form-translatable-textarea
                        name="description"
                        :label="__('Description')"
                        :rows="3"
                        :placeholder="__('Description about the category')"
                    />

                    <x-admin.form-image
                        name="image"
                        :label="__('Category Image')"
                    />

                    <x-admin.form-input
                        name="order"
                        type="number"
                        :label="__('Order')"
                        :value="0"
                        min="0"
                        :hint="__('Smaller values are shown first')"
                    />

                    <x-admin.form-toggle
                        name="is_active"
                        :label="__('Active')"
                        :description="__('Category appears on site')"
                        :checked="true"
                    />
                </div>
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    {{ __('Create Category') }}
                </x-admin.button>
                <x-admin.button href="{{ route('admin.categories.index') }}" variant="ghost">
                    {{ __('Cancel') }}
                </x-admin.button>
            </div>
        </div>
    </form>
@endsection
