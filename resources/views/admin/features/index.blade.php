@extends('layouts.admin')

@section('title', 'Ozellikler')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Ozellikler</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Ozellikler</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $features->count() }} ozellik</p>
        </div>
        <x-admin.button href="{{ route('admin.features.create') }}" icon="fa-plus">
            Yeni Ozellik
        </x-admin.button>
    </div>

    <!-- Position Filter -->
    <x-admin.card class="mb-6" :padding="false">
        <div class="p-4 flex gap-2 flex-wrap">
            <a href="{{ route('admin.features.index') }}"
               class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ !request('position') ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Tumu
            </a>
            @foreach($positions as $key => $label)
                <a href="{{ route('admin.features.index', ['position' => $key]) }}"
                   class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request('position') === $key ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </x-admin.card>

    <!-- Features Table -->
    <x-admin.data-table :headers="[
        ['label' => 'Ikon', 'width' => '70px'],
        ['label' => 'Baslik', 'width' => '20%'],
        'Aciklama',
        ['label' => 'Pozisyon', 'class' => 'text-center'],
        ['label' => 'Sira', 'class' => 'text-center'],
        ['label' => 'Durum', 'class' => 'text-center'],
        ['label' => 'Islemler', 'class' => 'text-right', 'width' => '120px'],
    ]">
        @forelse($features as $feature)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                        <i data-lucide="{{ $feature->icon }}" class="w-5 h-5 text-slate-600"></i>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-slate-900">{{ $feature->title }}</p>
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm text-slate-600 line-clamp-1">{{ Str::limit($feature->description, 50) }}</p>
                </td>
                <td class="px-4 py-3 text-center">
                    <x-admin.badge variant="default" size="sm">
                        {{ $positions[$feature->position] ?? $feature->position }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm text-slate-600">{{ $feature->order }}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.features.toggle-status', $feature) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <x-admin.badge :variant="$feature->is_active ? 'success' : 'danger'" size="sm" dot>
                                {{ $feature->is_active ? 'Aktif' : 'Pasif' }}
                            </x-admin.badge>
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.features.edit', $feature) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="Duzenle">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('admin.features.destroy', $feature) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Bu ozelligi silmek istediginizden emin misiniz?')">
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
                <td colspan="7" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-star"
                        title="Ozellik bulunamadi"
                        description="Henuz ozellik eklenmemis"
                        action="Yeni Ozellik Ekle"
                        :actionUrl="route('admin.features.create')"
                    />
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
@endpush
