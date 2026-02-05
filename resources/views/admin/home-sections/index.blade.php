@extends('layouts.admin')

@section('title', 'Ana Sayfa Bolumleri')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Ana Sayfa Bolumleri</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Ana Sayfa Bolumleri</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $sections->count() }} bolum</p>
        </div>
        <x-admin.button href="{{ route('admin.home-sections.create') }}" icon="fa-plus">
            Yeni Bolum
        </x-admin.button>
    </div>

    <!-- Info Card -->
    <x-admin.card class="mb-6" :padding="false">
        <div class="p-4 flex items-center gap-3 text-sm text-slate-600">
            <i class="fas fa-info-circle text-primary-500"></i>
            <span>Bolumleri surukleyerek siralayabilirsiniz. Siralama otomatik kaydedilir.</span>
        </div>
    </x-admin.card>

    <!-- Sections Table -->
    <x-admin.data-table :headers="[
        ['label' => 'Sira', 'width' => '80px'],
        ['label' => 'Tip', 'width' => '150px'],
        ['label' => 'Baslik', 'width' => '35%'],
        ['label' => 'Durum', 'class' => 'text-center'],
        ['label' => 'Islemler', 'class' => 'text-right', 'width' => '120px'],
    ]">
        @forelse($sections as $section)
            <tr class="hover:bg-slate-50 transition-colors" data-id="{{ $section->id }}">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-grip-vertical text-slate-300 cursor-move"></i>
                        <span class="text-sm text-slate-600">{{ $section->order }}</span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <x-admin.badge variant="primary" size="sm">
                        {{ $types[$section->type] ?? $section->type }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-slate-900">{{ $section->title ?: '(Basliksiz)' }}</p>
                    @if($section->subtitle)
                        <p class="text-xs text-slate-500 mt-0.5">{{ $section->subtitle }}</p>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.home-sections.toggle-status', $section) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <x-admin.badge :variant="$section->is_active ? 'success' : 'danger'" size="sm" dot>
                                {{ $section->is_active ? 'Aktif' : 'Pasif' }}
                            </x-admin.badge>
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.home-sections.edit', $section) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="Duzenle">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('admin.home-sections.destroy', $section) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Bu bolumu silmek istediginizden emin misiniz?')">
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
                <td colspan="5" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-layer-group"
                        title="Bolum bulunamadi"
                        description="Henuz ana sayfa bolumu eklenmemis"
                        action="Yeni Bolum Ekle"
                        :actionUrl="route('admin.home-sections.create')"
                    />
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
