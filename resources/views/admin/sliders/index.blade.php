@extends('layouts.admin')

@section('title', __('Sliders'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Sliders') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Sliders') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $sliders->count() }} slider</p>
        </div>
        <x-admin.button href="{{ route('admin.sliders.create') }}" icon="fa-plus">
            {{ __('New Slider') }}
        </x-admin.button>
    </div>

    <!-- Sliders Table -->
    <x-admin.data-table :headers="[
        ['label' => __('Image'), 'width' => '160px'],
        ['label' => __('Title'), 'width' => '30%'],
        ['label' => __('Position'), 'class' => 'text-center'],
        ['label' => __('Order'), 'class' => 'text-center'],
        ['label' => __('Status'), 'class' => 'text-center'],
        ['label' => __('Actions'), 'class' => 'text-right', 'width' => '120px'],
    ]">
        @forelse($sliders as $slider)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <img src="{{ $slider->image_url }}"
                         alt="{{ $slider->title }}"
                         class="w-32 h-20 object-cover rounded-lg border border-slate-200">
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-slate-900">{{ $slider->title ?: __('(No title)') }}</p>
                    @if($slider->subtitle)
                        <p class="text-xs text-slate-500 mt-0.5">{{ $slider->subtitle }}</p>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <x-admin.badge variant="default" size="sm">
                        {{ ucfirst($slider->text_position) }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm text-slate-600">{{ $slider->order }}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.sliders.toggle-status', $slider) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <x-admin.badge :variant="$slider->is_active ? 'success' : 'danger'" size="sm" dot>
                                {{ $slider->is_active ? __('Active') : __('Inactive') }}
                            </x-admin.badge>
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.sliders.edit', $slider) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="{{ __('Edit') }}">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('{{ __('Are you sure you want to delete this slider?') }}')">
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
                        icon="fa-images"
                        :title="__('No sliders found')"
                        :description="__('No sliders have been added yet')"
                        :action="__('Add New Slider')"
                        :actionUrl="route('admin.sliders.create')"
                    />
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
