@extends('layouts.admin')
@section('title', 'Bannerlar')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Bannerlar ({{ $banners->count() }})</h2>
    <a href="{{ route('admin.banners.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
        <i class="fas fa-plus mr-2"></i>Yeni Banner
    </a>
</div>

<!-- Position Filter -->
<div class="flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('admin.banners.index') }}" class="px-3 py-1 rounded {{ !request('position') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">Tumu</a>
    @foreach($positions as $key => $label)
        <a href="{{ route('admin.banners.index', ['position' => $key]) }}" class="px-3 py-1 rounded {{ request('position') === $key ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">{{ $label }}</a>
    @endforeach
</div>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Gorsel</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Ad</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Pozisyon</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Sira</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($banners as $banner)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <img src="{{ $banner->image_url }}" class="w-32 h-20 object-cover rounded">
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-medium">{{ $banner->name }}</p>
                        @if($banner->title)
                            <p class="text-sm text-gray-500">{{ $banner->title }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $positions[$banner->position] ?? $banner->position }}</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $banner->order }}</td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.banners.toggle-status', $banner) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-2 py-1 rounded text-xs {{ $banner->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $banner->is_active ? 'Aktif' : 'Pasif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Henuz banner eklenmemis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
