@extends('layouts.admin')

@section('title', __('Edit Category'))

@section('breadcrumb')
    <a href="{{ route('admin.categories.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Categories') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $category->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit Category') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $category->name }}</p>
        </div>
        <form action="{{ route('admin.categories.destroy', $category) }}"
              method="POST"
              onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                {{ __('Delete') }}
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="max-w-2xl">
            <x-admin.card :title="__('Category Information')">
                <div class="space-y-4">
                    <x-admin.form-translatable-input
                        name="name"
                        :label="__('Category Name')"
                        :value="$category->getTranslations('name')"
                        required
                    />

                    <x-admin.form-input
                        name="slug"
                        :label="__('Slug')"
                        :value="$category->slug"
                    />

                    <x-admin.form-select
                        name="parent_id"
                        :label="__('Parent Category')"
                        :value="$category->parent_id"
                        :options="$parentCategories->pluck('name', 'id')->toArray()"
                        :placeholder="__('- Main Category -')"
                    />

                    <x-admin.form-translatable-textarea
                        name="description"
                        :label="__('Description')"
                        :value="$category->getTranslations('description')"
                        :rows="3"
                    />

                    <x-admin.form-image
                        name="image"
                        :label="__('Category Image')"
                        :value="$category->image"
                    />

                    <x-admin.form-input
                        name="order"
                        type="number"
                        :label="__('Order')"
                        :value="$category->order"
                        min="0"
                    />

                    <x-admin.form-toggle
                        name="is_active"
                        :label="__('Active')"
                        :description="__('Category appears on site')"
                        :checked="$category->is_active"
                    />
                </div>
            </x-admin.card>

            <x-admin.card :title="__('Information')" class="mt-6">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">{{ __('Product Count') }}</span>
                        <span class="text-slate-900 font-medium">{{ $category->products_count ?? $category->products()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">{{ __('Created') }}</span>
                        <span class="text-slate-900">{{ $category->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">{{ __('Last Updated') }}</span>
                        <span class="text-slate-900">{{ $category->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    {{ __('Save Changes') }}
                </x-admin.button>
                <x-admin.button href="{{ route('admin.categories.index') }}" variant="ghost">
                    {{ __('Cancel') }}
                </x-admin.button>
            </div>
        </div>
    </form>
@endsection
