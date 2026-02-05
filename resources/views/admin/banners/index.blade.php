@extends('layouts.admin')

@section('title', __('Banners'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Banners') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Banners') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $banners->count() }} {{ __('banner') }}</p>
        </div>
        <x-admin.button href="{{ route('admin.banners.create') }}" icon="fa-plus">
            {{ __('New Banner') }}
        </x-admin.button>
    </div>

    <!-- Position Filter -->
    <x-admin.card class="mb-6" :padding="false">
        <div class="p-4 flex gap-2 flex-wrap">
            <a href="{{ route('admin.banners.index') }}"
               class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ !request('position') ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ __('All') }}
            </a>
            @foreach($positions as $key => $label)
                <a href="{{ route('admin.banners.index', ['position' => $key]) }}"
                   class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request('position') === $key ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </x-admin.card>

    <!-- Banners Table -->
    <x-admin.data-table :headers="[
        ['label' => __('Image'), 'width' => '160px'],
        ['label' => __('Name'), 'width' => '25%'],
        ['label' => __('Position'), 'class' => 'text-center'],
        ['label' => __('Order'), 'class' => 'text-center'],
        ['label' => __('Status'), 'class' => 'text-center'],
        ['label' => __('Actions'), 'class' => 'text-right', 'width' => '120px'],
    ]">
        @forelse($banners as $banner)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <img src="{{ $banner->image_url }}"
                         alt="{{ $banner->name }}"
                         class="w-32 h-20 object-cover rounded-lg border border-slate-200">
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-slate-900">{{ $banner->name }}</p>
                    @if($banner->title)
                        <p class="text-xs text-slate-500 mt-0.5">{{ $banner->title }}</p>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <x-admin.badge variant="default" size="sm">
                        {{ $positions[$banner->position] ?? $banner->position }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm text-slate-600">{{ $banner->order }}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.banners.toggle-status', $banner) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <x-admin.badge :variant="$banner->is_active ? 'success' : 'danger'" size="sm" dot>
                                {{ $banner->is_active ? __('Active') : __('Inactive') }}
                            </x-admin.badge>
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.banners.edit', $banner) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="{{ __('Edit') }}">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('{{ __('Are you sure you want to delete this banner?') }}')">
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
                <td colspan="6" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-image"
                        :title="__('No banners found')"
                        :description="__('No banners have been added yet')"
                        :action="__('Add New Banner')"
                        :actionUrl="route('admin.banners.create')"
                    />
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
