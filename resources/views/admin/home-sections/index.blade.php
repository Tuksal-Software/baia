@extends('layouts.admin')
@section('title', 'Ana Sayfa Bolumleri')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Ana Sayfa Bolumleri ({{ $sections->count() }})</h2>
    <a href="{{ route('admin.home-sections.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
        <i class="fas fa-plus mr-2"></i>Yeni Bolum
    </a>
</div>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Sira</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tip</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Baslik</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th>
            </tr>
        </thead>
        <tbody class="divide-y" id="sortable-sections">
            @forelse($sections as $section)
                <tr class="hover:bg-gray-50" data-id="{{ $section->id }}">
                    <td class="px-4 py-3 text-gray-600">
                        <i class="fas fa-grip-vertical cursor-move mr-2 text-gray-400"></i>
                        {{ $section->order }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-gray-100 rounded text-sm">{{ $types[$section->type] ?? $section->type }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-medium">{{ $section->title ?: '(Baslıksız)' }}</p>
                        @if($section->subtitle)
                            <p class="text-sm text-gray-500">{{ $section->subtitle }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.home-sections.toggle-status', $section) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-2 py-1 rounded text-xs {{ $section->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $section->is_active ? 'Aktif' : 'Pasif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.home-sections.edit', $section) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.home-sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">Henuz bolum eklenmemis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<p class="text-sm text-gray-500 mt-4"><i class="fas fa-info-circle mr-1"></i> Bolumleri surukleyerek siralayabilirsiniz.</p>
@endsection
