@extends('layouts.admin')
@section('title', 'Ozellikler')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Ozellikler ({{ $features->count() }})</h2>
    <a href="{{ route('admin.features.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
        <i class="fas fa-plus mr-2"></i>Yeni Ozellik
    </a>
</div>

<!-- Position Filter -->
<div class="flex gap-2 mb-4">
    <a href="{{ route('admin.features.index') }}" class="px-3 py-1 rounded {{ !request('position') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">Tumu</a>
    @foreach($positions as $key => $label)
        <a href="{{ route('admin.features.index', ['position' => $key]) }}" class="px-3 py-1 rounded {{ request('position') === $key ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">{{ $label }}</a>
    @endforeach
</div>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Ikon</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Baslik</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Aciklama</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Pozisyon</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Sira</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($features as $feature)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <i data-lucide="{{ $feature->icon }}" class="w-5 h-5 text-gray-600"></i>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $feature->title }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($feature->description, 50) }}</td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $positions[$feature->position] ?? $feature->position }}</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $feature->order }}</td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.features.toggle-status', $feature) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-2 py-1 rounded text-xs {{ $feature->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $feature->is_active ? 'Aktif' : 'Pasif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.features.edit', $feature) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">Henuz ozellik eklenmemis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
@endpush
