@extends('layouts.admin')

@section('title', 'Sliderlar')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Sliderlar</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Sliderlar</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $sliders->count() }} slider</p>
        </div>
        <x-admin.button href="{{ route('admin.sliders.create') }}" icon="fa-plus">
            Yeni Slider
        </x-admin.button>
    </div>

    <!-- Sliders Table -->
    <x-admin.data-table :headers="[
        ['label' => 'Gorsel', 'width' => '160px'],
        ['label' => 'Baslik', 'width' => '30%'],
        ['label' => 'Pozisyon', 'class' => 'text-center'],
        ['label' => 'Sira', 'class' => 'text-center'],
        ['label' => 'Durum', 'class' => 'text-center'],
        ['label' => 'Islemler', 'class' => 'text-right', 'width' => '120px'],
    ]">
        @forelse($sliders as $slider)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <img src="{{ $slider->image_url }}"
                         alt="{{ $slider->title }}"
                         class="w-32 h-20 object-cover rounded-lg border border-slate-200">
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-slate-900">{{ $slider->title ?: '(Basliksiz)' }}</p>
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
                                {{ $slider->is_active ? 'Aktif' : 'Pasif' }}
                            </x-admin.badge>
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.sliders.edit', $slider) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="Duzenle">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Bu slideri silmek istediginizden emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="Sil">
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
                        title="Slider bulunamadi"
                        description="Henuz slider eklenmemis"
                        action="Yeni Slider Ekle"
                        :actionUrl="route('admin.sliders.create')"
                    />
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
