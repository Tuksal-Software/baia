@extends('layouts.admin')

@section('title', __('Categories'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Categories') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Categories') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __(':count categories', ['count' => $categories->count()]) }}</p>
        </div>
        <x-admin.button href="{{ route('admin.categories.create') }}" icon="fa-plus">
            {{ __('New Category') }}
        </x-admin.button>
    </div>

    <!-- Categories Table -->
    <x-admin.data-table :headers="[
        ['label' => __('Category'), 'width' => '35%'],
        __('Parent Category'),
        ['label' => __('Product Count'), 'class' => 'text-center'],
        ['label' => __('Status'), 'class' => 'text-center'],
        ['label' => __('Actions'), 'class' => 'text-right', 'width' => '120px'],
    ]">
        @forelse($categories as $category)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        @if($category->image)
                            <img src="{{ $category->image_url }}"
                                 alt="{{ $category->name }}"
                                 class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                        @else
                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                <i class="fas fa-folder text-slate-400"></i>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $category->name }}</p>
                            <p class="text-xs text-slate-500">{{ $category->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    @if($category->parent)
                        <span class="text-sm text-slate-600">{{ $category->parent->name }}</span>
                    @else
                        <span class="text-sm text-slate-400">-</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <x-admin.badge variant="default" size="sm">
                        {{ $category->products_count }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <x-admin.badge :variant="$category->is_active ? 'success' : 'danger'" size="sm" dot>
                                {{ $category->is_active ? __('Active') : __('Inactive') }}
                            </x-admin.badge>
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="{{ __('Edit') }}">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('{{ __('Are you sure you want to delete this category? Products inside may be affected.') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="{{ __('Delete') }}">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-folder"
                        :title="__('Category not found')"
                        :description="__('No categories have been added yet')"
                        :action="__('Add New Category')"
                        :actionUrl="route('admin.categories.create')"
                    />
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
